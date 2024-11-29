<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $messageData = [
            'username' => $request->username,
            'email' => $request->email,
            'textOfMessage' => $request->textOfMessage,
            'userIP'=> $request->userIP,
            'userBrowser'=> $request->userIP,
        ];

        Message::create($messageData);
        return response()->json([
            'status' => 200,
        ]);
    }
    public function getall()
    {
        $messages = Message::all();
        return response()->json([
            'status' => 200,
            'messages' => $messages
        ]);
    }
    public function delete(Request $request)
    {
        $message = Message::find($request->id);
        if ($message && $message->delete()) {
            return response()->json(['status' => 200, 'message' => 'Message deleted successfully.']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to delete message.']);
        }
    }
}
