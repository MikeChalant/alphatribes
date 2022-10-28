<?php

namespace App\Http\Controllers;

use App\Models\GroupUser;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatWebsocketController extends Controller implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        // get the token from the connection
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray); // convert string to array

        //Update socket connection for the token id
        if(isset($queryArray['token'])){
            User::where('dynamic_token', $queryArray['token'])->update([
                'socket_connection_id'=>$conn->resourceId,
                'live_status' => 'online'
            ]);
        }
        echo "Websocket Server Started!";
    }

    public function onMessage(ConnectionInterface $conn, $message)
    {
        $data = json_decode($message);

        //Send one to one message
        if($data->entity_type === 'user'){
            //if message type is text
            if($data->messsage_type === 'text'){
                $message = new Message();
                $message->user_id = $data->user_id;
                $message->entity_id = $data->entity_id;
                $message->entity_type = $data->entity_type;
                $message->message_type = $data->message_type;
                $message->message = $data->message;
                $message->save();
            }

            $receiver_connection_id = User::where('id',$data->user_id)->select('socket_connection_id')->first(); 
            $sender_connection_id = User::where('id',$data->entity_id)->select('socket_connection_id')->first(); 


            foreach($this->clients as $client){

                if($client->resourceId == $receiver_connection_id->socket_connection_id || 
                    $client->resourceId == $sender_connection_id->socket_connection_id)
                {
                    $client->send($message);
                }
            }
        }

        // Send group chat
        if($data->entity_type === 'group'){

            // get all users of the group and send message
            $groupUsers = GroupUser::where('group_id', $data->entity_id)->select('user_id')->get()->toArray();
            $users = User::whereIn('id', array_column($groupUsers, 'user_id'))->get();

            // Save message if message type is text
            if($data->messsage_type === 'text'){
                $message = new Message();
                $message->user_id = $data->user_id;
                $message->entity_id = $data->entity_id;
                $message->entity_type = $data->entity_type;
                $message->message_type = $data->message_type;
                $message->message = $data->message;
                $message->save();
            }

            //Send to connected users of the group
            foreach($this->clients as $client){
                foreach($users as $user){
                    if($client->resourceId == $user->socket_connection_id)
                    {
                        $client->send($message);
                    }
                }
            }

        }

    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        // get the token from the connection
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray); // convert string to array

        //Update socket connection id to 0, live status, and last seen
        if(isset($queryArray['token'])){
            User::where('dynamic_token', $queryArray['token'])->update([
                'socket_connection_id'=>0,
                'live_status' => 'offline',
                'last_seen' => date('y-m-d h:i:s')
            ]);
        }

        echo "Websocket Server Closed!";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()} \n";
        $conn->close();
    }
}
