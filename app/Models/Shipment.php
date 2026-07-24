<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';

    const STATUS_PENDING    = 1;
    const STATUS_SHIPPED    = 2;
    const STATUS_IN_TRANSIT = 3;
    const STATUS_DELIVERED  = 4;
    const STATUS_RETURNED   = 5;

    const STATUSES = [
        self::STATUS_PENDING    => 'Pending',
        self::STATUS_SHIPPED    => 'Shipped',
        self::STATUS_IN_TRANSIT => 'In Transit',
        self::STATUS_DELIVERED  => 'Delivered',
        self::STATUS_RETURNED   => 'Returned',
    ];

    const STATUSES_AR = [
        self::STATUS_PENDING    => 'قيد الانتظار',
        self::STATUS_SHIPPED    => 'تم الشحن',
        self::STATUS_IN_TRANSIT => 'في الطريق',
        self::STATUS_DELIVERED  => 'تم التسليم',
        self::STATUS_RETURNED   => 'مرتجع',
    ];

    protected $fillable = [
        'order_id',
        'shipping_method_id',
        'tracking_number',
        'status',
        'shipped_at',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public $timestamps = true;

    public function getStatusLabelAttribute(): string
    {
        $labels = app()->getLocale() === 'ar' ? self::STATUSES_AR : self::STATUSES;
        return $labels[$this->status] ?? 'Unknown';
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function images()
    {
        return $this->hasMany(ShipmentImage::class, 'shipment_id')->orderBy('sort_order');
    }
}
