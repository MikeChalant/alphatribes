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
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Pusher\Pusher;

class MessageController extends Controller
{
     // Fetch all contact messages and generate dynamic token for the websocket
     public function recentMessages()
     {
          $messages = $this->userRecentMessages();

          //get the groups user belongs to
          $groupIds = GroupUser::where('user_id', auth()->id())->select('group_id')->get()->toArray();

          //get group recent messages
          $groupIdValues = implode(",", array_column($groupIds, 'group_id'));
          $groupsMessages = $this->groupRecentMessages($groupIdValues);
               
          $recentMessages = (array) array_merge($messages,$groupsMessages);

          // Sort the messages by id desc
          array_multisort(array_column($recentMessages, 'id'),SORT_DESC, $recentMessages);

          return $this->appResponse(true, 'success', 'recent messages', ['recent_messages'=>$recentMessages], 200);
     }

     /* Fetch All chat history with a user */
     public function userChats(Request $request)
     {
          $chats = Message::query()
               ->where(function($query) use($request){
                    $query->where('user_id', auth()->id())
                    ->where('entity_id', $request->id);
               })
               ->orWhere(function($query) use($request){
                    $query->where('user_id', $request->id)
                    ->where('entity_id', auth()->id());
               })
               ->where('entity_type', 'user')
               ->paginate(100); 

          //user detail of chat receiver
          $user = User::where('id', $request->id)->select('id','name','phone_no','user_image')->first();
          
          return $this->appResponse(true,'success','',['user'=>$user, 'chats'=>$chats], 200);
     }

     /* Fetch All chat history for a group*/
     public function groupChats(Request $request)
     {
          $chats = Message::query()
               ->where('entity_id', $request->id)
               ->where('entity_type', 'group')
               ->paginate(100);
          $group = Group::where('id', $request->id)->select('id','group_name','image')->first();

          return $this->appResponse(true,'success','',['group'=>$group, 'chats'=>$chats], 200);
     }
     
     /* Saves message to the database not in use */
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

     public function uploadMessageFiles(Request $request)
     {
          $validator = Validator::make($request->all(),[
               'message_file' => ['required','mimes:doc,pdf,docx,zip,txt,jpeg,png,jpg,gif,svg'],
               'entity_id' => ['required','integer','min:1'],
               'entity_type' => ['required','string','max:10'],
               'message_type' => ['required','string'],
          ]);
          if($validator->fails()){
               return $this->appResponse(false, 'error',$validator->errors()->first(), $validator->errors(), 422);
          }

          if($request->hasFile('message_file')) {
                    
               $file = $request->file('message_file') ;
               $fileName = $file->getClientOriginalName() ;
               $destinationPath = public_path().'/images/user'.auth()->id();
               if(!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777,true);
               }
               //Upload file
               $file->move($destinationPath,$fileName);

               //Save file name to db
               $message = new Message();
               $message->user_id = auth()->id();
               $message->entity_id = $request->entity_id;
               $message->entity_type = $request->entity_type;
               $message->message_type = $request->message_type;
               $message->message_file = $fileName;
               $message->save();

               //return path and file for websocket
               $messageFile = 'https://'.$_SERVER['HTTP_HOST'].'/images/user'.auth()->id().'/'.$fileName;
               return $this->appResponse(true,'success','',['message_file'=>$messageFile], 201);
          }
     }

     /* Delete message */
     public function deleteMessage($id)
     {
          $message = Message::where('id', $id)
               ->where('user_id', auth()->id())->first();
          $message->delete();
          return $this->appResponse(true, 'success', '', [], 200);
     }

     private function userRecentMessages()
     {
          return DB::select("SELECT t1.id, t1.user_id, t1.entity_id,t1.entity_type, t1.message, users.name, users.user_image
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
               WHERE t1.entity_type = 'user' AND (t1.user_id = ? OR t1.entity_id = ?)", [auth()->id(),auth()->id()]);
     }

     private function groupRecentMessages($groupIdValues)
     {
          return DB::select("SELECT t1.id, t1.user_id, t1.entity_id,t1.entity_type, t1.message,`groups`.id group_id, `groups`.`group_name`,`groups`.`image`
          FROM messages AS t1
          INNER JOIN
          (
               SELECT
                    entity_id,MAX(id) AS max_id
               FROM messages
               GROUP BY entity_id
          ) AS t2
          ON 
               t1.entity_id = t2.entity_id AND t1.id = t2.max_id
          INNER JOIN `groups` ON (`groups`.id = t1.entity_id)
          WHERE t1.entity_type = 'group' AND t1.entity_id IN ({$groupIdValues})");
     }

     public function websocketToken()
     {
          // Generate dynamic token used to authenticate the websocket
          $token = md5(uniqid());
          $authUser = User::where('id', auth()->id())->first();
          $authUser->dynamic_token = $token;
          $authUser->save();
          return $this->appResponse(true, 'success', '', ['token'=>$token], 200);
     }

}


