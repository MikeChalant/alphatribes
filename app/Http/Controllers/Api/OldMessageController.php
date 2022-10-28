<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Pusher\Pusher;

class MessageController extends Controller
{
     // Fetch all contact messages and generate dynamic token for the websocket
     public function recentMessages()
     {
          $messages = DB::select("SELECT t1.id, t1.user_id, t1.entity_id,t1.entity_type, t1.message, users.name, users.user_image
               FROM messages AS t1
               INNER JOIN
               (
                    SELECT
                         LEAST(user_id, entity_id) AS user_id,
                         GREATEST(user_id, entity_id) AS entity_id,
                         MAX(id) AS max_id
                    FROM messages
                    GROUP BY
                         LEAST(user_id, entity_id),
                         GREATEST(user_id, entity_id)
               ) AS t2
               ON LEAST(t1.user_id, t1.entity_id) = t2.user_id AND
                    GREATEST(t1.user_id, t1.entity_id) = t2.entity_id AND
                    t1.id = t2.max_id
               INNER JOIN users ON (users.id = t1.entity_id)
               WHERE t1.entity_type = 'user' AND (t1.user_id = 15 OR t1.entity_id = 15)");

          return $this->appResponse(true, 'success', 'recent messages', ['recent_messages'=>$messages], 200);
     }
     
     public function contactRecentMessagesOld()
     {
          // Get user contact ids from the user messages
          $contactIds = Message::where(function($query){
               $query->where('user_id', auth()->id())
                    ->orWhere('entity_id', auth()->id());
               })
               ->where('entity_type', 'user')
               ->select('user_id','entity_id')->distinct('user_id','entity_id')->get()->toArray();

          $userFrom = array_column($contactIds, 'user_id');
          $userTo = array_column($contactIds, 'entity_id');
          $userIds = array_merge($userFrom, $userTo);
          $uniqueUserIds =  array_unique($userIds);

          //remove logged in user from the contact Ids
          if(($key = array_search(auth()->id(), $uniqueUserIds)) !== false) {
               unset($uniqueUserIds[$key]);
          }
          $userContactIds = array_values($uniqueUserIds);

          // Get group Ids of groups user belong to
          $groups = GroupUser::where('user_id', auth()->id())->select('group_id')->get()->toArray();
          $groupIds = array_column($groups, 'group_id');

          ////
          $test = DB::select("SELECT m.id,m.entity_id, m.message, u.name, u.id FROM messages m LEFT JOIN users u ON m.user_id = u.id AND m.id IN (SELECT MAX(sm.id) FROM messages sm 
          WHERE sm.user_id = u.id) WHERE m.entity_id = 15 AND m.user_id = u.id GROUP BY u.id,m.id,m.message,u.name,m.entity_id ORDER BY m.id DESC");
               return $test;
           
          return $this->appResponse(true,'success','',['ids'=>$groupIds],200);

          // $messages = Message::query()
          //      ->where('')
     }

     /* Fetch All chat with a user */
     public function userChats(Request $request)
     {
          $chats = Message::query()
               ->where(function($query){
                    $query->where('user_id', auth()->id())
                    ->orWhere('entity_id', auth()->id());
               })
               ->where(function($query) use($request){
                    $query->where('user_id', $request->id)
                    ->orWhere('entity_id', $request->id);
               })
               ->where('entity_type', 'user')
               ->simplePaginate(100); 

          $user = User::where('id', 15)->select('id','name','phone_no','user_image')->first();

          return $this->appResponse(true,'success','',['user'=>$user, 'chats'=>$chats], 200);
     }

     /* Fetch All chat for a group*/
     public function groupChats(Request $request)
     {
          $chats = Message::query()
               ->where('entity_id', $request->id)
               ->where('entity_type', 'group')
               ->simplePaginate(100);
          $group = Group::where('id', $request->id)->select('id','group_name')->first();

          return $this->appResponse(true,'success','',['group'=>$group, 'chats'=>$chats], 200);
     }
     
     /* Saves message to the database */
     public function store(Request $request)
     {

         $message = new Message();
         $message->user_id = auth()->id();
         $message->entity_id = $request->entity_id;
         $message->entity_type = $request->entity_type;
         $message->message = $request->message ?? null;
         $message->message_type = empty($request->message)? 'file' : 'text';
         $message->save();
         return $this->appResponse(true,'success','message sent',['message'=>$message],201);
 
         //Save files if any
        //  if($request->hasFile('message_file')){

        //     // upload Image
        //     $orignalName = $request->file('user_image')->getClientOriginalName();
        //     $fileExt = $request->file('user_image')->getClientOriginalExtension();
        //     $fileName = pathinfo($orignalName, PATHINFO_FILENAME);
        //     $imageName = time().'_'.$fileName.'.'.$fileExt;
    
        //     $imageFolder = 'images/'.$request->file;
        //     if(!is_dir(public_path($imageFolder)))
        //         mkdir(public_path($imageFolder), 0777);
    
        //     Image::make($request->file('user_image')->getRealPath())
        //         // ->fit(350,350)
        //         ->save($imageFolder.'/'.$imageName);
        // }
     }

     /* Delete message */
     public function deleteMessage($id)
     {
          $message = Message::where('id', $id)
               ->where('user_id', auth()->id())->first();
          $message->delete();
          return $this->appResponse(true, 'success', '', [], 204);
     }

     public function connect(Request $request)
     {
          $broadcaster = new PusherBroadcaster(
               new Pusher(
                    env("PUSHER_APP_KEY"),
                    env("PUSHER_APP_SECRET"),
                    env("PUSHER_APP_ID"),
                    []
               )
          );

          return $broadcaster->validAuthenticationResponse($request, []);

     }

     

     
     public function recentSQl()
     {


     
     $best = "SELECT t1.id, t1.user_id, t1.entity_id,t1.entity_type, t1.message, users.name, users.user_image
     FROM messages AS t1
     INNER JOIN
     (
         SELECT
             LEAST(user_id, entity_id) AS user_id,
             GREATEST(user_id, entity_id) AS entity_id,
             MAX(id) AS max_id
         FROM messages
         GROUP BY
             LEAST(user_id, entity_id),
             GREATEST(user_id, entity_id)
     ) AS t2
         ON LEAST(t1.user_id, t1.entity_id) = t2.user_id AND
            GREATEST(t1.user_id, t1.entity_id) = t2.entity_id AND
            t1.id = t2.max_id
      INNER JOIN users ON (users.id = t1.entity_id)
         WHERE t1.entity_type = 'user' AND (t1.user_id = 15 OR t1.entity_id = 15);";






     $alternative = "SELECT t2.msgMaxId, t2.receiver2_id,t2.name, messages.sender_id,messages.receiver_id,messages.message 
               FROM (SELECT t1.receiver2_id, users.name, max(mid) msgMaxId
               FROM (SELECT messages.receiver_id receiver2_id, max(messages.id) mid
               FROM messages WHERE messages.sender_id=15
               GROUP BY messages.receiver_id
           UNION DISTINCT
           (SELECT messages.receiver_id receiver2_id, max(messages.id) mid
               FROM messages WHERE messages.receiver_id=15
               GROUP BY messages.receiver_id)
           ) t1
           INNER JOIN users ON (users.id = t1.receiver2_id)
           GROUP BY t1.receiver2_id
           ORDER BY msgMaxId DESC) t2
           JOIN messages ON (t2.msgMaxId = messages.id) 
           ORDER BY t2.msgMaxId DESC";


     $bestCopy = "SELECT t1.*, users.name
     FROM messages AS t1
     INNER JOIN
     (
         SELECT
             LEAST(user_id, entity_id) AS user_id,
             GREATEST(user_id, entity_id) AS entity_id,
             MAX(id) AS max_id
         FROM messages
         GROUP BY
             LEAST(user_id, entity_id),
             GREATEST(user_id, entity_id)
     ) AS t2
         ON LEAST(t1.user_id, t1.entity_id) = t2.user_id AND
            GREATEST(t1.user_id, t1.entity_id) = t2.entity_id AND
            t1.id = t2.max_id
      INNER JOIN users ON (users.id = t1.entity_id)
         WHERE t1.user_id = 15 OR t1.entity_id = 15 ";
     }
}


