<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    // public function index()
    // {
    //     // Fetch the chat messages and pass them to the chat view
    //     $messages = Message::with('sender', 'receiver')->get();

    //     return view('chat.chat', compact('messages'));
    // }

    public function chat($user_id)
    {
        // Fetch the chat messages and pass them to the chat view
        // Fetch the chat messages between the authenticated user and the receiver
        $senderId = auth()->id();

        $messages = Message::select('messages.message', 'senders.name as sender_name', 'receivers.name as receiver_name')
            ->join('users as senders', 'messages.sender_id', '=', 'senders.id')
            ->join('users as receivers', 'messages.receiver_id', '=', 'receivers.id')
            ->whereIn('messages.sender_id', [$senderId, $user_id])
            ->whereIn('messages.receiver_id', [$senderId, $user_id])
            ->orderBy('messages.created_at', 'asc')
            ->get();

        $receiverName = User::where('id', $user_id)->value('name');
        $user = User::where('id', $user_id)->first();
        return view('chat.chat_testing', ['messages' => $messages,'user_id' => $user_id, 'receiverName' => $receiverName, 'user' => $user]);
    }


    public function send(Request $request)
    {
        // Create a new message
        $message = new Message([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        $message->save();

        // Redirect back to the chat view
        // return redirect()->route('chat.chat', ['user_id' => $request->receiver_id]);
        return response()->json(['success' => true, 'user_id' => $request->receiver_id]);
    }

    public function messagesChat($user_id)
    {
        $receiverId = $user_id;
        $senderId = auth()->id();
        // Retrieve the chat messages from the database and join with the users table
        $messages = Message::select(
            'messages.message',
            'messages.sender_id',
            'messages.receiver_id',
            'senders.name as sender_name',
            'receivers.name as receiver_name',
            'messages.created_at',
            'senders.image_path as sender_image_path',
            'receivers.image_path as receiver_image_path',
        )
            ->join('users as senders', 'messages.sender_id', '=', 'senders.id')
            ->join('users as receivers', 'messages.receiver_id', '=', 'receivers.id')
            ->whereIn('messages.sender_id', [$senderId, $receiverId])
            ->whereIn('messages.receiver_id', [$senderId, $receiverId])
            ->whereColumn('messages.sender_id', '!=', 'messages.receiver_id')
            ->orderBy('messages.created_at', 'asc')
            ->get();


        // Return a JSON response with the messages, sender name, and receiver name
        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function userChat($user_id)
    {
        // $receiverId = $user_id;
        $senderId = auth()->id();
        // Retrieve the chat messages from the database and join with the users table
        $messages = Message::select(
            'm.sender_id',
            'm.receiver_id',
            'm.message',
            'm.created_at',
            DB::raw("CASE WHEN m.sender_id = $senderId THEN receiver.id ELSE sender.id END as user_id"),
            DB::raw("CASE WHEN m.sender_id = $senderId THEN receiver.name ELSE sender.name END as user_name"),
            DB::raw("CASE WHEN m.sender_id = $senderId THEN sender.image_path ELSE receiver.image_path END as image_path")
        )
            ->from('messages as m')
            ->join('users as sender', 'm.sender_id', '=', 'sender.id')
            ->join('users as receiver', 'm.receiver_id', '=', 'receiver.id')
            ->where(function ($query) use ($senderId) {
                $query->where('m.sender_id', $senderId)
                    ->orWhere('m.receiver_id', $senderId);
            })
            ->where(function ($query) use ($senderId) {
                $query->whereRaw('m.created_at = (
                    SELECT MAX(created_at) 
                    FROM messages 
                    WHERE (sender_id = m.sender_id AND receiver_id = m.receiver_id)
                        OR (sender_id = m.receiver_id AND receiver_id = m.sender_id)
                )');
            })
            ->orderBy('m.created_at', 'desc')
            ->get();
        

        // ->get();
        // Return a JSON response with the messages, sender name, and receiver name
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
