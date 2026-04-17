<?php

namespace App\Models;

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
		'delivery_fee', 
		'quotation_type', 
		'deleted_at', 
	];
    public $timestamps = true;

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
		if (!$this->schedule_start_date) {
			return 'upcoming';
		}
		
		$now = now();
		$startDate = \Carbon\Carbon::parse($this->schedule_start_date);
		
		// Check if there's an accepted offer
		$acceptedOffer = $this->offers()
			->whereIn('status', [2, '2', 'accepted'])
			->first();
		
		if ($acceptedOffer) {
			// Check timeline for completion
			$completedTimeline = $this->timeline()->where('timeline_no', 6)->exists();
			if ($completedTimeline) {
				return 'completed';
			}
			
			// Active if started
			if ($now->gte($startDate)) {
				return 'active';
			}
			
			return 'upcoming';
		}
		
		// Check if order is cancelled/rejected
		$rejectedOffer = $this->offers()->whereIn('status', [3, '3', 'rejected'])->exists();
		if ($rejectedOffer && $this->offers()->whereIn('status', [1, '1', 'pending'])->count() === 0) {
			return 'cancelled';
		}
		
		// Check if paused (no activity for long time with pending offers)
		if ($this->offers()->whereIn('status', [1, '1', 'pending'])->exists() && $this->updated_at->diffInDays($now) > 7) {
			return 'paused';
		}
		
		// Upcoming by default
		return $now->lt($startDate) ? 'upcoming' : 'active';
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
		$statusClasses = [
			'pending' => 'bg-warning-subtle text-warning',
			'confirmed' => 'bg-success-subtle text-success',
			'processing' => 'bg-primary-subtle text-primary',
			'shipped' => 'bg-info-subtle text-info',
			'delivered' => 'bg-success-subtle text-success',
			'completed' => 'bg-success-subtle text-success',
			'canceled' => 'bg-danger-subtle text-danger',
			'under_review' => 'bg-secondary-subtle text-secondary',
			'assigned_to_supplier' => 'bg-primary-subtle text-primary',
			'converted_to_order' => 'bg-primary-subtle text-primary',
			'offers_received' => 'bg-info-subtle text-info',
			'supplier_selected' => 'bg-secondary-subtle text-secondary',
			'upcoming' => 'bg-secondary-subtle text-secondary',
			'active' => 'bg-primary-subtle text-primary',
			'paused' => 'bg-warning-subtle text-warning',
			'rejected' => 'bg-danger-subtle text-danger',
		];

		$timeline = $this->relationLoaded('timeline') ? $this->timeline : $this->timeline()->get();
		$offers = $this->relationLoaded('offers') ? $this->offers : $this->offers()->get();
		$lastTimelineNo = optional($timeline->sortByDesc('timeline_no')->first())->timeline_no;
		$timelineStatusKey = $this->timelineStatusKey((int) $lastTimelineNo);

		if ((int) $this->request_type === 2) {
			$statusKey = $this->normalizeStatusKey((string) $this->scheduled_status);
			$statusText = $this->translatedAdminStatus($statusKey);

			return [
				'text' => $statusText,
				'key' => $statusKey,
				'class' => $statusClasses[$statusKey] ?? 'bg-warning-subtle text-warning',
			];
		}

		if ($providerId) {
			$myOffer = $offers->where('provider_id', (int) $providerId)->first();
			if ($myOffer) {
				$offerStatus = strtolower((string) $myOffer->status);
				if ($offerStatus === '2' || $offerStatus === 'accepted') {
					$statusKey = 'confirmed';
				} elseif ($offerStatus === '3' || $offerStatus === 'rejected') {
					$statusKey = 'rejected';
				} else {
					$statusKey = $timelineStatusKey;
				}
			} else {
				$statusKey = $timelineStatusKey;
			}
		} else {
			$acceptedOffer = $offers->first(function ($offer) {
				$status = strtolower((string) $offer->status);
				return $status === '2' || $status === 'accepted';
			});

			$rejectedOffersCount = $offers->filter(function ($offer) {
				$status = strtolower((string) $offer->status);
				return $status === '3' || $status === 'rejected';
			})->count();

			if ($acceptedOffer) {
				$statusKey = 'confirmed';
			} elseif ($offers->count() > 0 && $rejectedOffersCount === $offers->count()) {
				$statusKey = 'rejected';
			} else {
				$statusKey = $timelineStatusKey;
			}
		}

		$statusText = $this->translatedAdminStatus($statusKey);

		return [
			'text' => $statusText,
			'key' => $statusKey,
			'class' => $statusClasses[$statusKey] ?? 'bg-warning-subtle text-warning',
		];
	}

	private function normalizeStatusKey(string $status): string
	{
		$key = strtolower(trim($status));
		$key = str_replace(' ', '_', $key);

		return match ($key) {
			'cancelled' => 'canceled',
			default => $key !== '' ? $key : 'pending',
		};
	}

	private function timelineStatusKey(int $timelineNo): string
	{
		return match ($timelineNo) {
			1 => 'order_created',
			2 => 'confirmed',
			3 => 'processing',
			4 => 'shipped',
			5 => 'delivered',
			6 => 'completed',
			7 => 'offers_received',
			8 => 'supplier_selected',
			9 => 'converted_to_order',
			10 => 'under_review',
			11 => 'assigned_to_supplier',
			12 => 'canceled',
			default => 'pending',
		};
	}

	private function translatedAdminStatus(string $statusKey): string
	{
		$key = $this->normalizeStatusKey($statusKey);
		$translationKey = 'admin.pages.orders.statuses.' . $key;
		$translated = __($translationKey);

		if ($translated !== $translationKey) {
			return $translated;
		}

		return ucwords(str_replace('_', ' ', $key));
	}
		
	public function fildes(){
		return [
			'user_id' => '', 
			'device_category_id' => '', 
			'coupon_id' => '', 
			'provider_id' => '', 
			'offer_id' => '', 
			'order_type' => '', 
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

}
