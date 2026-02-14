<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'iban',
        'branch',
        'tax_number',
        'cr_number',
        'cr_document',
        'location',
        'img',
        'fcm_token',
        'code',
        'user_type',
        'mobile_verified_at',
        'email_verified_at',
        'lang',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
	public function scopeGetProviders($query){
		return $query->where('user_type', 2);
	}
    
	public function scopeActive($query){
		return $query->where('is_activate', 1);
	}
	
	public function scopeUnActive($query){
		return $query->where('is_activate', 0);
	}

	public function scopeArchive($query){
		return $query->whereNotNull('deleted_at');
	}
	
	public function scopeUnArchive($query){
		return $query->whereNull('deleted_at');
	}

	public function fildes(){
		return [
            'img' => '',
			'name' => '',
            'email' => '',
            'mobile' => '',
            'iban' => '',
            'branch' => '',
            'password' => '',
            'tax_number' => '',
            'cr_document' => '',
            'cr_file_document' => '',
            'cr_number' => '',
            'location' => '',
            'fcm_token' => '',
            'user_type' => '',
            'code' => '',
		];
	}

	public function scopeModelSearch($model, $query)
	{
		return $model->latest()->where('id', 'LIKE', '%'. $query .'%')
					 ->orWhere('name', 'LIKE', '%'. $query .'%')
					 ->limit(PAGINATION_COUNT);
	}

	public function scopeModelSearchInArchives($model, $query)
	{
		return $model->latest()->where('id', 'LIKE', '%'. $query .'%')
					 ->orWhere('name', 'LIKE', '%'. $query .'%')
					 ->limit(PAGINATION_COUNT);
	}

	public function model_relations()
	{
		return [];
	}

	public function model_relations_counts()
	{
		return [];
	}

    public function orders()
	{
		return $this->hasMany(Order::class, 'user_id')->latest();
	}

    public function provider_orders()
	{
		return $this->hasMany(Order::class, 'provider_id')->latest();
	}

    public function cart()
	{
		return $this->hasMany(Cart::class, 'user_id');
	}

    public function favorites()
	{
		return $this->hasMany(Favorite::class, 'user_id');
	}

    public function notifications()
	{
		return $this->hasMany(Notification::class, 'user_id')->orderBy('id', 'DESC');
	}
    
	public function ratings()
    {
        return $this->morphMany(Rating::class, 'forable')->where('is_activate', 1);
    }
    
	public function avg_rating()
    {
        return round((float) $this->ratings()->avg('rate'), 2);
    }

    /**
     * Get conversations where user is participant
     */
    public function conversations()
    {
        return Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }

    /**
     * Get sent messages
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get received messages
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get unread messages count
     */
    public function unreadMessagesCount()
    {
        return $this->receivedMessages()->where('is_read', false)->count();
    }

    /**
     * Get conversation with another user
     */
    public function getConversationWith($userId)
    {
        return Conversation::between($this->id, $userId);
    }

}
