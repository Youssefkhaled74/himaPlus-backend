<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
	protected $fillable = [
		'title', 
		'content',
		'message',
		'type',
		'action_url',
		'meta',
		'read_at',
		'order_id', 
		'user_id', 
		'serviceable_id', 
		'serviceable_type',
	];
	
	protected $casts = [
        'meta' => 'array',
        'read_at' => 'datetime',
    ];
	
    public $timestamps = true;

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
	
	public function scopeUnread($query){
		return $query->whereNull('read_at');
	}
	
	public function scopeRead($query){
		return $query->whereNotNull('read_at');
	}
	
	public function scopeByType($query, $type){
		return $query->where('type', $type);
	}
	
	public function fildes(){
		return [
			'title' => '',
			'content' => '',
			'order_id' => '',
			'user_id' => '',
			'serviceable_id' => '',
			'serviceable_type' => '',
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

	public function serviceable()
    {
        return $this->morphTo();
    }

	public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

	public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}