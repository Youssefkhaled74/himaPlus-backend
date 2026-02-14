<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message_at',
        'is_blocked',
        'blocked_by'
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'last_message_at' => 'datetime'
    ];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function blockedByUser()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public static function between($userOne, $userTwo)
    {
        return static::where(function ($query) use ($userOne, $userTwo) {
            $query->where('user_one_id', $userOne)
                  ->where('user_two_id', $userTwo);
        })->orWhere(function ($query) use ($userOne, $userTwo) {
            $query->where('user_one_id', $userTwo)
                  ->where('user_two_id', $userOne);
        })->first();
    }

    public static function getOrCreate($userOne, $userTwo)
    {
        $conversation = self::between($userOne, $userTwo);

        if (!$conversation) {
            $conversation = self::create([
                'user_one_id' => min($userOne, $userTwo),
                'user_two_id' => max($userOne, $userTwo)
            ]);
        }

        return $conversation;
    }

    public function getOtherUser($userId)
    {
        return $this->user_one_id == $userId ? $this->userTwo : $this->userOne;
    }

    public function markAsRead($userId)
    {
        return $this->messages()
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    public function isParticipant($userId)
    {
        return $this->user_one_id == $userId || $this->user_two_id == $userId;
    }
}