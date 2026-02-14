<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPartialReceive extends Model
{
    protected $table = 'order_partial_receive';
	protected $fillable = [
		'order_id', 
		'user_id', 
		'offer_id', 
		'files', 
		'received_quantity', 
		'received_all_quantity', 
		'reason_for_partial', 
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
	
	public function fildes(){
		return [
			'order_id' => '', 
			'user_id' => '', 
			'offer_id' => '', 
			'files' => '', 
			'received_quantity' => '', 
			'received_all_quantity' => '', 
			'reason_for_partial' => '', 
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
}