<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
	protected $fillable = ['name'];
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
		return ['name' => ''];
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

	public function ratings()
	{
		return $this->hasMany(Rating::class, 'report_id')->orderBy('rating', 'DESC')->active()->unArchive();
	}

	public function categories()
	{
		return $this->hasMany(Category::class, 'report_id')->active()->unArchive()->inRandomOrder();
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'report_id')->active()->unArchive()->inRandomOrder();
	}

	public function category()
	{
		return $this->hasOne(Category::class, 'report_id')->active()->unArchive();
	}

	public function offers()
	{
		return $this->hasMany(Product::class, 'report_id')->active()->unArchive()->isOffer();
	}

	public function featured()
	{
		return $this->hasMany(Product::class, 'report_id')->active()->unArchive()->isSpecial();
	}
}