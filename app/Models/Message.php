<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'message_type',
        'file',
        'is_read',
        'read_at',
        'is_deleted_by_sender',
        'is_deleted_by_receiver'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_deleted_by_sender' => 'boolean',
        'is_deleted_by_receiver' => 'boolean',
        'read_at' => 'datetime'
    ];

    protected $appends = ['file_url'];

    /**
     * Get the conversation that owns the message
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the sender of the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the message
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get file URL attribute
     */
    public function getFileUrlAttribute()
    {
        if ($this->file) {
            return asset($this->file);
        }
        return null;
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for messages visible to a user
     */
    public function scopeVisibleTo($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where(function ($subQ) use ($userId) {
                $subQ->where('sender_id', $userId)
                     ->where('is_deleted_by_sender', false);
            })->orWhere(function ($subQ) use ($userId) {
                $subQ->where('receiver_id', $userId)
                     ->where('is_deleted_by_receiver', false);
            });
        });
    }

    /**
     * Delete message for a specific user (soft delete)
     */
    public function deleteForUser($userId)
    {
        if ($this->sender_id == $userId) {
            $this->update(['is_deleted_by_sender' => true]);
        } elseif ($this->receiver_id == $userId) {
            $this->update(['is_deleted_by_receiver' => true]);
        }

        // If both users deleted the message, delete the file and message permanently
        if ($this->is_deleted_by_sender && $this->is_deleted_by_receiver) {
            if ($this->file) {
                Storage::disk('public')->delete($this->file);
            }
            $this->delete();
        }
    }

    /**
     * Determine if the message contains a file
     */
    public function hasFile()
    {
        return $this->message_type === 'file' && $this->file !== null;
    }
}