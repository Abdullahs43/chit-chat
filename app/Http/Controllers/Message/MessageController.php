<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\PrivateMessageEvent;
use App\Http\Requests\UserMessageRequest;

class MessageController extends Controller
{
    public function conversation($userId) {
        $users = User::where('id', '!=', Auth::id())->get();
        $friendInfo = User::findOrFail($userId);
        $myInfo = User::find(Auth::id());
        $groups = MessageGroup::get();

        $this->data['users'] = $users;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myInfo'] = $myInfo;
        $this->data['users'] = $users;
        $this->data['groups'] = $groups;

        return view('message.conversation', $this->data);
    }

    public function sendMessage(UserMessageRequest $request) {

        $message = new Message();
        $message->message = $request->message;

        if ($message->save()) {
          
            try {
                $message->users()->attach(Auth::id(), ['receiver_id' => $request->receiver_id]);
                $data = [];
                $data['sender_id'] = Auth::id();
                $data['sender_name'] = Auth::user()->name;
                $data['receiver_id'] = $request->receiver_id;
                $data['content'] = $message->message;
                $data['created_at'] = $message->created_at;
                $data['message_id'] = $message->id;
             
                 event(new PrivateMessageEvent($data));

                return response()->json([
                   'data' => $data,
                   'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
    }

    public function sendGroupMessage(Request $request) {
        
        $request->validate([
            'message' => 'required',
            'message_group_id' => 'required'
        ]);

        $sender_id = Auth::id();
        $messageGroupId = $request->message_group_id;

        $message = new Message();
        $message->message = $request->message;

        if ($message->save()) {
            try {
                $message->users()->attach($sender_id, ['message_group_id' => $messageGroupId]);
                $sender = User::where('id', '=', $sender_id)->first();

                $data = [];
                $data['sender_id'] = $sender_id;
                $data['sender_name'] = $sender->name;
                $data['content'] = $message->message;
                $data['created_at'] = $message->created_at;
                $data['message_id'] = $message->id;
                $data['group_id'] = $messageGroupId;
                $data['type'] = 2;

                event(new GroupMessageEvent($data));

                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
    }
}
