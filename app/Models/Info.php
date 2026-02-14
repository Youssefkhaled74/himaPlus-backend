<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'info';
	protected $fillable = [
		'mobile',
		'email',
		'vat',
		'desc',
		'message',
		'vision',
		'asks',
		'abouts',
		'terms',
		'privacy_policies',
		'location',
		'facebook',
		'instagram',
		'twitter',
		'snapchat',
		'tiktok',
	];
    public $timestamps = true;
	protected $casts = [
		'asks' => 'array',
		'abouts' => 'array',
		'terms' => 'array',
		'privacy_policies' => 'array',
	];
	
	// public function getAsksAttribute($value)
	// {
	// 	return explode(',', $value);	
	// }
	
	// public function getAboutsAttribute($value)
	// {
	// 	return explode(',', $value);	
	// }
	
	// public function getTermsAttribute($value)
	// {
	// 	return explode(',', $value);	
	// }
	
	// public function getPrivacyPoliciesAttribute($value)
	// {
	// 	return explode(',', $value);	
	// }

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
			'mobile' => '',
			'email' => '',
			'vat' => '',
			'desc' => '',
			'message' => '',
			'vision' => '',
			'asks' => '',
			'abouts' => '',
			'terms' => '',
			'privacy_policies' => '',
			'location' => '',
			'facebook' => '',
			'instagram' => '',
			'twitter' => '',
			'snapchat' => '',
			'tiktok' => '',
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