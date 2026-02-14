<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';
	protected $fillable = [
		'files', 
		'cost', 
		'delivery_fee', 
		'delivery_time', 
		'warranty', 
		'provider_id', 
		'order_id', 
		'status', 
		'notes', 
		'rejected_reson', 
	];
    public $timestamps = true;

	public function getFilesAttribute($value)
    {
        return explode(',', $value);
    }

	// 1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped, 
	// 5 => Delivered, 6 => Completed, 7 => Offers Received, 8 => Supplier Selected, 
	// 9 => Converted to Order, 10 => Under Review, 11 => Assigned to Supplier

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
			'files' => '', 
			'cost' => '', 
			'delivery_fee' => '', 
			'delivery_time' => '', 
			'warranty' => '', 
			'provider_id' => '', 
			'order_id' => '', 
			'status' => '', 
			'notes' => '', 
			'rejected_reson' => '', 
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

	public function provider()
	{
		return $this->belongsTo(User::class, 'provider_id');
	}

	public function order()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}
}