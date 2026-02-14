<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
	protected $fillable = [
		'name',
		'category_id',
		'desc',
		'price',
		'img',
		'imgs',
		'stock_quantity',
		'imaging_type',
		'power',
		'manufacture_date',
		'production_date',
		'expiry_date',
		'weight',
		'dimensions',
		'warranty',
		'origin_id',
		'provider_id',
		'is_offer',
		'is_special',
	];
    public $timestamps = true;

	public function getImgsAttribute($value)
	{
		if (is_null($value) || $value === '') return [];

		// If already an array (some callers may set the attribute), return as-is
		if (is_array($value)) return $value;

		// Try to decode JSON
		$decoded = @json_decode($value, true);
		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
			return array_values($decoded);
		}

		// Try removing escaping then decode
		$stripped = stripslashes($value);
		$decoded2 = @json_decode($stripped, true);
		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded2)) {
			return array_values($decoded2);
		}

		// Fallback: split by comma and clean fragments (handles legacy comma lists and exploded JSON strings)
		$parts = array_map('trim', explode(',', $value));
		$clean = [];
		foreach ($parts as $p) {
			// remove surrounding quotes and brackets
			$p = preg_replace('/^[\[\]\s"\']+|[\[\]\s"\']+$/', '', $p);
			$p = stripslashes($p);
			$p = ltrim($p, '\/');
			if ($p !== '') $clean[] = $p;
		}

		// Deduplicate while preserving order
		$result = [];
		foreach ($clean as $c) {
			if (!in_array($c, $result)) $result[] = $c;
		}
		return $result;
	}

	public function scopeIsOffer($query){
		return $query->where('is_offer', 1);
	}

	public function scopeIsSpecial($query){
		return $query->where('is_special', 1);
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
			'name' => '',
			'category_id' => '',
			'desc' => '',
			'price' => '',
			'stock_quantity' => '',
			'img' => '',
			'imgs' => '',
			'imaging_type' => '',
			'power' => '',
			'manufacture_date' => '',
			'production_date' => '',
			'expiry_date' => '',
			'weight' => '',
			'dimensions' => '',
			'warranty' => '',
			'origin_id' => '',
			'provider_id' => '',
			'is_offer' => '',
			'is_special' => '',
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
		return ['category', 'origin'];
	}

	public function model_relations_counts()
	{
		return [];
	}

	public function order_item()
	{
		return $this->hasMany(OrderItem::class, 'product_id');
	}

	public function is_favorite()
	{
		return $this->hasOne(Favorite::class, 'product_id')->where('user_id', auth()->user()->id ?? 0);
	}
	
	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function origin()
	{
		return $this->belongsTo(Country::class, 'origin_id');
	}

	public function provider()
	{
		return $this->belongsTo(User::class, 'provider_id');
	}
	
	public function ratings()
    {
        return $this->morphMany(Rating::class, 'forable')->where('is_activate', 1);
    }
	
	public function top_rating()
    {
        return $this->morphMany(Rating::class, 'forable')->where('is_activate', 1)->orderBy('rating', 'DESC')->limit(2);
    }
	
	public function related_products()
    {
        return $this->hasMany(self::class, 'category_id', 'category_id')->inRandomOrder()->limit(3);
    }
}