<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                                    'content' => $lastMessage->message ?? 'Gửi file',
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
                    'message' => $message->message,
                    'message_type' => $message->message_type, // ✅ thêm loại tin nhắn (text, image, file)
                    'file_url' => $message->file_url ? asset('storage/'.$message->file_url) : null, // ✅ link ảnh/file
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:nguoi_dung,id',
            'message' => 'nullable|string|max:1000',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,pdf,doc,docx,mp3,mp4|max:10240', // file tùy chỉnh theo bạn
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        $messages = []; // ✅ Mảng chứa tất cả messages vừa tạo

        // dd($request->all());
        //   try {

            // Nếu có files, lưu file và tạo record phụ (có thể lưu file vào bảng khác hoặc thêm bản ghi message cho từng file)
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    // dump($file->);
                     // Tạo hash (md5/sha1) để kiểm tra file trùng
                    $fileHash = md5_file($file->getRealPath());
                    $fileName = $fileHash.'.'.$file->getClientOriginalExtension();
                    $path = 'chat_files/'.$fileName;

                    // Nếu file chưa tồn tại thì mới lưu
                    if (!Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->put($path, file_get_contents($file));
                    }
                    // $path = $file->store('chat_files', 'public'); // lưu trong storage/app/public/chat_files
                    // dump($path);
                    // Kiểm tra loại file để set message_type
                    $type = str_contains($file->getMimeType(), 'image') ? 'image' : 'file';
                    // dump($type);
                    // Tạo message file, hoặc bạn có bảng riêng lưu file attach
                    $msg = Message::create([
                        'sender_id' => Auth::id(),
                        'receiver_id' => $request->receiver_id,
                        'message_type' => $type,  // nhớ thêm cột message_type trong bảng message
                        'file_url' => $path,
                        'is_read' => 0
                    ]);
                    $msg->load(['sender.hoSo', 'receiver.hoSo']);

                    $messages[] = [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'message_type' => $msg->message_type,
                        'file_url' => $msg->file_url ? asset('storage/'.$msg->file_url) : null,
                        'sender_id' => $msg->sender_id,
                        'receiver_id' => $msg->receiver_id,
                        'is_read' => $msg->is_read,
                        'created_at' => $msg->created_at->format('H:i'),
                        'created_at_full' => $msg->created_at->format('Y-m-d H:i:s'),
                        'sender' => [
                            'id' => $msg->sender->id,
                            'name' => ($msg->sender->hoSo->ho ?? '') . ' ' . ($msg->sender->hoSo->ten ?? ''),
                            'avatar' => $msg->sender->hoSo->anh_dai_dien ?? 'assets/images/default.png'
                        ],
                        'is_own_message' => true
                    ];
                    $fullPath = storage_path('app/public/'.$path);
                    if (file_exists($fullPath)) {
                        broadcast(new MessageSent($msg));
                    }
                    // Broadcast từng file nếu cần
                    // broadcast(new MessageSent($msg));
                }
            }
        // ✅ Nếu có text message
            if ($request->filled('message')) {
                $message = Message::create([
                    'sender_id' => Auth::id(),
                    'receiver_id' => $request->receiver_id,
                    'message' => $request->message ?? null,
                    'is_read' => 0
                ]);
                $message->load(['sender.hoSo', 'receiver.hoSo']);
                // Broadcast event

                $messages[]= [

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

                ];
                broadcast(new MessageSent($message));
            }
            return response()->json([
                'success' => true,
                'data' => $messages // ✅ Trả về toàn bộ tin nhắn (file + text)
            ], 201);

            // dd($message);


        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Có lỗi xảy ra khi gửi tin nhắn',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }

    public function getMessages(NguoiDung $user)
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
    public function typing(Request $request)
    {
        // dd($request->all());
        $receiverId = $request->input('receiver_id');

        broadcast(new \App\Events\UserTyping(auth()->id(), $receiverId));

        return response()->json(['status' => 'broadcasted']);
    }
    public function stoppedTyping(Request $request)
    {
        $receiverId = $request->input('receiver_id');

        broadcast(new \App\Events\UserStoppedTyping(auth()->id(), $receiverId));

        return response()->json(['status' => 'broadcasted']);
    }
}
