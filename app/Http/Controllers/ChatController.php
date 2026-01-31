<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a list of conversations.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get all unique users who have exchanged messages with current user
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get()
            ->map(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            })
            ->unique();

        $users = User::whereIn('id', $conversations)->get();

        return view('chat.index', compact('users'));
    }

    /**
     * Display the chat with a specific user.
     */
    public function show($id)
    {
        $otherUser = User::findOrFail($id);
        $userId = Auth::id();

        $messages = Message::where(function ($query) use ($userId, $id) {
            $query->where('sender_id', $userId)->where('receiver_id', $id);
        })->orWhere(function ($query) use ($userId, $id) {
            $query->where('sender_id', $id)->where('receiver_id', $userId);
        })->oldest()->get();

        // Mark as read
        Message::where('sender_id', $id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('otherUser', 'messages'));
    }

    /**
     * Send a new message.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $request->message,
        ]);

        // Optional: Notify receiver
        // $receiver = User::find($id);
        // $receiver->notify(new NewMessageNotification($message));

        return back();
    }

    /**
     * Redirect to chat with an admin.
     */
    public function support()
    {
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return back()->with('error', 'Support is currently unavailable.');
        }

        if ($admin->id === Auth::id()) {
            return redirect()->route('chat.index')->with('status', 'You are the administrator.');
        }

        return redirect()->route('chat.show', $admin->id);
    }
}
