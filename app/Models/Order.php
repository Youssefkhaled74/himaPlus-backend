<?php

namespace App\Models;

use App\Services\OrderStatusService;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
	protected $fillable = [
		
		// normal order
		'user_id', 
		'coupon_id', 
		'provider_id', 
		'order_type', 
		'discount', 
		'address', 
		'payment_type', 
		'gateway_name',
		'gateway_payment_id',
		'gateway_track_id',
		'gateway_response',
		'getway_transaction_id', 
		'payment_status', 
		'vat_amount', 
		'vat', 
		'items_cost', 
		'total_before_discount', 
		'total_cost', 
		
		// quotations
		'request_type', 
		'files', 
		'notes', 
		'date_time_picker',  
		'budget', 
		'delivery_duration', 
		'frequency', 
		'schedule_start_date', 
		// 'user_id', 
		// 'provider_id', 
		// 'order_type', 
		// 'address', 
		// 'payment_type', 
		// 'getway_transaction_id', 
		// 'payment_status', 
		
		// maintenancy
		'device_category_id', 
		'device_name', 
		'serial_number', 
		'issue_description', 
		'preferred_service_time', 
		// 'user_id', 
		// 'provider_id', 
		// 'files', 
		// 'address', 
		
		'offer_id',
		'shipping_method_id',
		'delivery_fee',
		'quotation_type', 
		'deleted_at', 
	];
    public $timestamps = true;

    protected $casts = [
        'gateway_response' => 'array',
    ];

	public function getFilesAttribute($value)
	{
		return explode(',', $value);	
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
	
	public function scopeScheduled($query){
		return $query->where('request_type', 2);
	}
	
	public function scopeNotScheduled($query){
		return $query->where(function($q){
			$q->where('request_type', 1)->orWhereNull('request_type');
		});
	}
	
	public function scopePurchaseOrders($query){
		return $query->where('order_type', 1);
	}
	
	public function scopeQuotations($query){
		return $query->where('order_type', 2);
	}
	
	public function scopeMaintenance($query){
		return $query->where('order_type', 3);
	}
	
	/**
	 * Get scheduled order status based on dates and offer status
	 */
	public function getScheduledStatusAttribute()
	{
		$status = $this->resolveStatus();

		return match ($status['key']) {
			OrderStatusService::STATUS_COMPLETED_SCHEDULED => 'completed',
			OrderStatusService::STATUS_ACTIVE_SCHEDULED => 'active',
			OrderStatusService::STATUS_CANCELLED => 'cancelled',
			default => 'upcoming',
		};
	}
	
	/**
	 * Get status badge color for scheduled orders
	 */
	public function getScheduledStatusColorAttribute()
	{
		return [
			'paused' => ['bg' => 'rgba(251,191,36,.12)', 'text' => '#92400e', 'border' => 'rgba(251,191,36,.20)'],
			'upcoming' => ['bg' => 'rgba(148,163,184,.12)', 'text' => '#475569', 'border' => 'rgba(148,163,184,.20)'],
			'active' => ['bg' => 'rgba(59,130,246,.12)', 'text' => '#1e40af', 'border' => 'rgba(59,130,246,.20)'],
			'completed' => ['bg' => 'rgba(34,197,94,.12)', 'text' => '#166534', 'border' => 'rgba(34,197,94,.20)'],
			'cancelled' => ['bg' => 'rgba(239,68,68,.12)', 'text' => '#991b1b', 'border' => 'rgba(239,68,68,.20)'],
		][$this->scheduled_status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280', 'border' => '#e5e7eb'];
	}

	public function resolveAdminStatus(?int $providerId = null): array
	{
		return $this->resolveStatus([
			'audience' => 'admin',
			'provider_id' => $providerId,
		]);
	}

	public function resolveStatus(array $context = []): array
	{
		$context['audience'] = $context['audience'] ?? 'front';

		return app(OrderStatusService::class)->resolveStatus($this, $context);
	}

	public function getFrontStatusAttribute(): array
	{
		return $this->resolveStatus(['audience' => 'front']);
	}

	public function getAdminStatusAttribute(): array
	{
		return $this->resolveAdminStatus();
	}
		
	public function fildes(){
		return [
			'user_id' => '',
			'device_category_id' => '',
			'coupon_id' => '',
			'provider_id' => '',
			'offer_id' => '',
			'order_type' => '',
			'request_type' => '',
			'payment_type' => '',
			'payment_status' => '',
			'vat' => '',
			'vat_amount' => '',
			'delivery_fee' => '',
			'discount' => '',
			'items_cost' => '',
			'total_before_discount' => '',
			'total_cost' => '',
			'address' => '',
			'files' => '',
			'notes' => '',
			'device_name' => '',
			'budget' => '',
			'quotation_type' => '',
			'serial_number' => '',
			'issue_description' => '',
			'date_time_picker' => '',
			'preferred_service_time' => '',
			'delivery_duration' => '',
			'frequency' => '',
			'schedule_start_date' => '',
			'gateway_name' => '',
			'gateway_payment_id' => '',
			'gateway_track_id' => '',
			'gateway_response' => '',
			'getway_transaction_id' => '',
			'deleted_at' => '',
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
		return ['user', 'device_category', 'coupon', 'provider'];
	}

	public function model_relations_counts()
	{
		return [];
	}

	public function items()
	{
		return $this->hasMany(OrderItem::class, 'order_id');
	}

	public function timeline()
	{
		return $this->hasMany(OrderTimeline::class, 'order_id');
	}

	public function offer()
	{
		return $this->belongsTo(Offer::class, 'offer_id');
	}

	public function offers()
	{
		return $this->hasMany(Offer::class, 'order_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function device_category()
	{
		return $this->belongsTo(Category::class, 'device_category_id');
	}

	public function coupon()
	{
		return $this->belongsTo(Coupon::class, 'coupon_id');
	}

	public function provider()
	{
		return $this->belongsTo(User::class, 'provider_id');
	}

	public function partial_receive()
	{
		return $this->hasMany(OrderPartialReceive::class, 'order_id');
	}

	public function shippingMethod()
	{
		return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
	}

	public function shipments()
	{
		return $this->hasMany(Shipment::class, 'order_id');
	}

}
