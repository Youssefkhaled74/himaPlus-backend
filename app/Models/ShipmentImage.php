<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentImage extends Model
{
    protected $table = 'shipment_images';

    protected $fillable = [
        'shipment_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    public $timestamps = true;

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    public function getImageUrlAttribute(): string
    {
        return asset($this->image_path);
    }
}
