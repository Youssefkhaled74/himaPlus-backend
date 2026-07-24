<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'base_price',
        'price_per_kg',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'price_per_kg' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public $timestamps = true;

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->name_ar ?: $this->name_en)
            : ($this->name_en ?: $this->name_ar);
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->description_ar ?: $this->description_en)
            : ($this->description_en ?: $this->description_ar);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'shipping_method_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_method_id');
    }

    public function calculateFee(float $weightKg = 0): float
    {
        return (float) $this->base_price + ($weightKg * (float) $this->price_per_kg);
    }
}
