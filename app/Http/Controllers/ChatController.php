<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Conversations;
use App\Events\ChatMessage;
use App\Events\ChatMessageOwn;
use App\Events\TypingEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class ChatController extends Controller
{

    public function createchat($userid){

        $conversation = Conversations::where('receiver_id',$userid)
                        ->where('sender_id',auth()->id())
                        ->with('chat')
                        ->first();

        /** Search vise versa */

        if(!isset($conversation)){

            $conversation = Conversations::where('sender_id',$userid)
                        ->where('receiver_id',auth()->id())
                        ->with('chat')
                        ->first();

        }

        if(!$conversation){

            $conversation                = new Conversations;
            $conversation->conv_id       = Str::uuid();
            $conversation->receiver_id   = $userid;
            $conversation->sender_id     = auth()->id();
            $conversation->save();

        }

        return redirect(route('chat.screen',$conversation->conv_id));
    }

    public function chatscreen($id){

        abort_if(!auth()->user()->can('chat.manage'),403,__('User does not have the right permissions.'));

        $conversation = Conversations::where('conv_id','=',$id)
                        ->with('chat')
                        ->firstOrfail();

        $reciever = $conversation->sender_id == auth()->id() ? $conversation->reciever : $conversation->sender;

        if( in_array('Seller',auth()->user()->getRoleNames()->toArray()) ){
    
            return view('seller.chat.chat',compact('conversation','reciever'));

        }

        return view('admin.chat.chat',compact('conversation','reciever'));

    }

    public function chatlist(){

        abort_if(!auth()->user()->can('chat.manage'),403,__('User does not have the right permissions.'));

        $conversations = Conversations::where('receiver_id','=',auth()->id())
                         ->orWhere('sender_id','=',auth()->id())
                         ->whereHas('chat')
                         ->orderBy('id','DESC')
                         ->get();

        if(request()->user){
            $users = User::where('name','LIKE','%'.request()->user.'%')
                     ->where('id','!=',auth()->id())
                     ->paginate(10,['id','name','image']);
        }else{
            $users = User::where('id','!=',auth()->id())
                     ->paginate(10,['id','name','image']);
        }

        if( in_array('Seller',auth()->user()->getRoleNames()->toArray()) ){
    
            return view('seller.chat.index',compact('conversations','users'));

        }

        return view('admin.chat.index',compact('conversations','users'));

    }

    public function userchat(){
        
        require 'price.php';

        $conversations = Conversations::whereHas('chat')
                        ->where('receiver_id','=',auth()->id())
                        ->orWhere('sender_id','=',auth()->id())
                        ->get();

        return view('user.mychat',compact('conversion_rate','conversations'));
    }

    public function userchatview($id){

        require 'price.php';

        $conversation = Conversations::where('conv_id','=',$id)
                        ->with('chat')
                        ->firstOrfail();

        return view('user.viewchat',compact('conversion_rate','conversation'));
    }

    public function sendmessage(Request $request,$conv_id){

       

       if($request->file('media')){

            $path = public_path() . '/images/conversations/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $file = $request->media;
            $type = __('media');

            $name = 'chat_media_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

           

            $img->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($path . '/' . $name, 95);
            //file upload code and pass image url in pusher and response
       }else{
        
            $type = __('text');

       }

        try{

            $chat = Chat::create([
                'message' => $request->message,
                'type'    => $type,
                'media'   => isset($name) ? $name : NULL,
                'conv_id' => $conv_id,
                'user_id' => auth()->id(),
            ]);

            $sender_data = array(
                'message'  => $request->message,
                'type'     => $type,
                'media'    => isset($name) ? url('images/conversations/'.$name) : NULL,
                'time'     => $chat->created_at->format('d-m-Y @ h:i A')
            );

            $reciver_data = array(
                'message'  => $request->message,
                'type'     => $type,
                'media'    => isset($name) ? url('images/conversations/'.$name) : NULL,
                'time'     => $chat->created_at->format('d-m-Y @ h:i A')
            );

            event(new ChatMessageOwn($sender_data, $conv_id,$sender_id = auth()->id()));

            event(new ChatMessage($reciver_data, $conv_id,$reciver_id = $request->rec_id));
    
            return response()->json([
                'status'  => 'success',
                'message' => __('sent')
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);

        }

    }

    public function typing(Request $request,$conv_id){

        
        try{
            event(new TypingEvent((int) $conv_id,(int) $request->receiver_id,(boolean) $request->typing));

            return response()->json([
                'status'  => 'success',
                'typing'  => (boolean) $request->typing,
                'message' => __('sent')
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);

        }

    }
}
