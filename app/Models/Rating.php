<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
	protected $fillable = ['comment', 'rating', 'user_id', 'forable_id', 'forable_type', 'is_activate'];
    public $timestamps = true;

	public function getForAttribute()
	{
		if ($this->forable_type == 'App\Models\User')
			return "Provider";
		elseif ($this->forable_type == 'App\Models\Product')
			return "Product";

		return '';
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
		return ['comment' => '', 'rating' => '', 'user_id' => ''];
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
		return ['user', 'forable'];
	}

	public function model_relations_counts()
	{
		return [];
	}

	public function forable()
    {
        return $this->morphTo();
    }

	public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}