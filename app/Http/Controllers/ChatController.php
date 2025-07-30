<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index()
    {
        $users = NguoiDung::where('id', '!=', Auth::id())
                ->whereHas('hoSo')
                ->with('hoSo')
                ->get();

        return view('chat.index', compact('users'));
    }
    public function getChatUsers()
    {
        // dd(Auth::id());
        try {
            $users = NguoiDung::
                        whereHas('hoSo')
                        ->with('hoSo')
                        ->where('id', '!=', Auth::id())
                        ->get()
                        ->map(function ($user) {
                            // Lấy tin nhắn cuối cùng
                            $lastMessage = Message::where(function ($query) use ($user) {
                                $query->where('sender_id', Auth::id())
                                      ->where('receiver_id', $user->id);
                            })->orWhere(function ($query) use ($user) {
                                $query->where('sender_id', $user->id)
                                      ->where('receiver_id', Auth::id());
                            })->orderBy('created_at', 'desc')
                              ->first();

                            // Đếm tin nhắn chưa đọc
                            $unreadCount = Message::where('sender_id', $user->id)
                                                 ->where('receiver_id', Auth::id())
                                                 ->where('is_read', false)
                                                 ->count();

                            return [
                                'id' => $user->id,
                                'name' => ($user->hoSo->ho ?? '') . ' ' . ($user->hoSo->ten ?? ''),
                                'avatar' => $user->hoSo->anh_dai_dien ?? 'assets/images/default.png',
                                'last_message' => $lastMessage ? [
                                    'content' => $lastMessage->message,
                                    'time' => $lastMessage->created_at->diffForHumans(),
                                    'is_own' => $lastMessage->sender_id == Auth::id()
                                ] : null,
                                'lastMessageTime' => $lastMessage ? $lastMessage->created_at : null, // 👈 Thêm dòng này
                                'unread_count' => $unreadCount
                            ];
                        }) ->sortByDesc('lastMessageTime') // 👉 Bây giờ mới sort được
    ->values();
                        // dd($users);

            return response()->json([
                'success' => true,
                'data' => $users
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show(NguoiDung $user)
    {
        // dd($user);
        // try {
            // Lấy tin nhắn giữa 2 user
            $messages = Message::where(function ($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })->with('sender', 'receiver')
              ->orderBy('created_at', 'asc')
              ->get();
            // dd($messages);
            // Đánh dấu tin nhắn là đã đọc
            Message::where('sender_id', $user->id)
                   ->where('receiver_id', Auth::id())
                   ->where('is_read', false)
                   ->update(['is_read' => true]);

            // Format dữ liệu trả về
            $formattedMessages = $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at->format('H:i'),
                    'created_at_full' => $message->created_at->format('Y-m-d H:i:s'),
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => ($message->sender->hoSo->ho ?? '') . ' ' . ($message->sender->hoSo->ten ?? ''),
                        'avatar' => $message->sender->hoSo->anh_dai_dien ?? 'assets/images/default.png'
                    ],
                    'is_own_message' => $message->sender_id == Auth::id()
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'messages' => $formattedMessages,
                    'user' => [
                        'id' => $user->id,
                        'name' => ($user->hoSo->ho ?? '') . ' ' . ($user->hoSo->ten ?? ''),
                        'avatar' => $user->hoSo->anh_dai_dien ?? 'assets/images/default.png'
                    ]
                ]
            ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Có lỗi xảy ra khi lấy tin nhắn',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }

    // public function show(NguoiDung $user)
    // {
    //     $messages = Message::where(function ($query) use ($user) {
    //         $query->where('sender_id', Auth::id())
    //               ->where('receiver_id', $user->id);
    //     })->orWhere(function ($query) use ($user) {
    //         $query->where('sender_id', $user->id)
    //               ->where('receiver_id', Auth::id());
    //     })->with(['sender', 'receiver'])
    //       ->orderBy('created_at', 'asc')
    //       ->get();

    //     // Đánh dấu tin nhắn là đã đọc
    //     Message::where('sender_id', $user->id)
    //            ->where('receiver_id', Auth::id())
    //            ->where('is_read', false)
    //            ->update(['is_read' => true]);

    //     return view('chat.show', compact('user', 'messages'));
    // }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);
        // dd($request->all());
          try {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->content,
                'is_read' => 0
            ]);

            $message->load(['sender.hoSo', 'receiver.hoSo']);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at->format('H:i'),
                    'created_at_full' => $message->created_at->format('Y-m-d H:i:s'),
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => ($message->sender->hoSo->ho ?? '') . ' ' . ($message->sender->hoSo->ten ?? ''),
                        'avatar' => $message->sender->hoSo->anh_dai_dien ?? 'assets/images/default.png'
                    ],
                    'is_own_message' => true
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi tin nhắn',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMessages(User $user)
    {
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })->with(['sender', 'receiver'])
          ->orderBy('created_at', 'asc')
          ->get();

        return response()->json($messages);
    }
}
