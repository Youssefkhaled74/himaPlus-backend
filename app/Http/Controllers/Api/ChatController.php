<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    use PushNotificationsTrait;

    public function __construct(){
        $this->middleware('auth:api', ['except' => []]);
    }

    public function getConversations(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $limit = $request->limit ?? 20;
        $offset = $request->offset ?? 0;

        $conversations = Conversation::where('user_one_id', $userId)
        ->orWhere('user_two_id', $userId)
        ->with(['userOne:id,name,img', 'userTwo:id,name,img', 'lastMessage'])
        ->orderBy('last_message_at', 'desc')
        ->skip($offset)
        ->take($limit)
        ->get()
        ->map(function ($conversation) use ($userId) {
            $otherUser = $conversation->getOtherUser($userId);
            $unreadCount = $conversation->unreadMessagesCount($userId);
            return [
                'id' => $conversation->id,
                'other_user' => [
                    'id' => $otherUser->id,
                    'name' => $otherUser->name,
                    'img' => $otherUser->img ? asset($otherUser->img) : null,
                ],
                'last_message' => $conversation->lastMessage ? [
                    'id' => $conversation->lastMessage->id,
                    'message' => $conversation->lastMessage->message,
                    'message_type' => $conversation->lastMessage->message_type,
                    'created_at' => $conversation->lastMessage->created_at,
                    'is_mine' => $conversation->lastMessage->sender_id == $userId
                ] : null,
                'unread_count' => $unreadCount,
                'is_blocked' => $conversation->is_blocked,
                'blocked_by' => $conversation->blocked_by,
                'last_message_at' => $conversation->last_message_at,
                'created_at' => $conversation->created_at
            ];
        });

        return responseJson(200, "success", $conversations);
    }

    public function getConversation(Request $request)
    {
        try {
            $user = auth()->user();
            $conversation = Conversation::getOrCreate($user->id, $request->receiver_id);
            return responseJson(200, "success", $conversation);
        } catch (\Exception $ex) {
            return responseJson(500, "there is something wrong , please contact technical support");
        }
    }

    public function getMessages(Request $request, $id, $offset, $limit)
    {
        $user = auth()->user();
        $userId = $user->id;
        $offset = $request->offset ?? 0;
        $conversation = Conversation::find($id);
        if (!$conversation || !$conversation->isParticipant($userId)) {
            return responseJson(404, "not found");
        }

        $conversation->markAsRead($userId);
        $messages = $conversation->messages()
        ->visibleTo($userId)
        ->with(['sender:id,name,img', 'receiver:id,name,img'])
        ->latest()
        ->skip($offset)
        ->take(PAGINATION_COUNT)
        ->get()
        ->map(function ($message) use ($userId) {
            $data = [
                'id' => $message->id,
                'message' => $message->message,
                'message_type' => $message->message_type,
                'file' => $message->file_url,
                'is_mine' => $message->sender_id == $userId,
                'is_read' => $message->is_read,
                'read_at' => $message->read_at,
                'sender' => [
                    'id' => $message->sender->id,
                    'name' => $message->sender->name,
                    'img' => $message->sender->img ? asset($message->sender->img) : null,
                ],
                'created_at' => $message->created_at
            ];
            return $data;
        });

        $data = [
            'conversation' => [
                'id' => $conversation->id,
                'is_blocked' => $conversation->is_blocked,
                'other_user' => $conversation->getOtherUser($userId)->only(['id', 'name', 'img'])
            ],
            'messages' => $messages->reverse()->values()
        ];
        return responseJson(200, "success", $data);
    }

    public function sendMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required_without:file',
                'file' => 'nullable|file|max:10240'
            ]);
            if ($validator->fails()) {
                return responseJson(400, "Bad Request", $validator->errors());
            }
    
            $user = auth()->user();
            $senderId = $user->id;
            $receiverId = $request->receiver_id;
            if ($senderId == $receiverId) {
                return responseJson(400, "must select user");
            }
    
            $conversation = Conversation::getOrCreate($senderId, $receiverId);
            $isNewConversation = $conversation->wasRecentlyCreated;
            if ($conversation->is_blocked) {
                return responseJson(403, "this conversation is blocked");
            }
    
            $messageData = [
                'conversation_id' => $conversation->id,
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message' => $request->message,
                'message_type' => 'text'
            ];
            if ($request->hasFile('file')) {
                $file = uploadIamge($request->file('file'), "chats");
                $messageData['file'] = $file;
                $messageData['message'] = null;
                $messageData['message_type'] = 'file';
            }
    
            $message = Message::create($messageData);
            $conversation->update(['last_message_at' => now()]);
            $message->load(['sender:id,name,img', 'receiver:id,name,img,fcm_token']);
            $this->targetFairbaseServicePushMessage($message, 2, $conversation->id, $message->receiver?->fcm_token ?? 'fcm_token');
            $this->targetFairbaseServicePushNotification($message->receiver?->fcm_token, "you have new message !", $message->message ?? $user->name . ' send message for you', 2, 0);
    
            $data = [
                'id' => $message->id,
                'conversation_id' => $conversation->id,
                'is_new_conversation' => $isNewConversation,
                'message' => $message->message,
                'message_type' => $message->message_type,
                'file' => $message->file_url,
                'is_mine' => true,
                'sender' => [
                    'id' => $message->sender->id,
                    'name' => $message->sender->name,
                    'img' => $message->sender->img ? asset($message->sender->img) : null,
                ],
                'receiver' => [
                    'id' => $message->receiver->id,
                    'name' => $message->receiver->name,
                    'img' => $message->receiver->img ? asset($message->receiver->img) : null,
                ],
                'created_at' => $message->created_at
            ];
            return responseJson(200, "success", $data);
        } catch (\Exception $ex) {
            return responseJson(500, "there is something wrong , please contact technical support");
        }
    }

    public function markAsRead($id)
    {
        try {
            $user = auth()->user();
            $userId = $user->id;
            Message::where('receiver_id', $userId)
            ->where('conversation_id', $id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
            return responseJson(200, "success");
        } catch (\Exception $ex) {
            return responseJson(500, "there is something wrong , please contact technical support");
        }
    }

    public function deleteMessage($messageId)
    {
        $user = auth()->user();
        $userId = $user->id;
        $message = Message::find($messageId);
        if (!$message) {
            return responseJson(500, "not found");
        }

        // Check if user is sender or receiver
        if ($message->sender_id != $userId && $message->receiver_id != $userId) {
            return responseJson(500, "not found");
        }

        $message->deleteForUser($userId);
        return responseJson(200, "success");
    }

    public function toggleBlockConversation($conversationId)
    {
        $userId = Auth::id();
        $conversation = Conversation::find($conversationId);

        if (!$conversation) {
            return response()->json([
                'status' => false,
                'message' => 'المحادثة غير موجودة'
            ], 404);
        }

        // Check if user is participant
        if (!$conversation->isParticipant($userId)) {
            return response()->json([
                'status' => false,
                'message' => 'غير مصرح لك بالتحكم في هذه المحادثة'
            ], 403);
        }

        if ($conversation->is_blocked) {
            // Unblock only if user is the one who blocked
            if ($conversation->blocked_by == $userId) {
                $conversation->update([
                    'is_blocked' => false,
                    'blocked_by' => null
                ]);
                $message = 'تم إلغاء حظر المحادثة';
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يمكنك إلغاء الحظر، المحادثة محظورة من الطرف الآخر'
                ], 403);
            }
        } else {
            // Block conversation
            $conversation->update([
                'is_blocked' => true,
                'blocked_by' => $userId
            ]);
            $message = 'تم حظر المحادثة';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'is_blocked' => $conversation->is_blocked,
                'blocked_by' => $conversation->blocked_by
            ]
        ]);
    }

    public function getUnreadCount($id)
    {
        $user = auth()->user();
        $userId = $user->id;
        $count = Message::where('receiver_id', $userId)
        ->where('conversation_id', $id)
        ->where('is_read', false)
        ->count();

        $data = ['unread_count' => $count];
        return responseJson(200, "success", $data);
    }
}