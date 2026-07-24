<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorBranch extends Model
{
    use SoftDeletes;

    protected $table = 'vendor_branches';

    protected $fillable = [
        'user_id',
        'name',
        'name_ar',
        'address',
        'city',
        'region',
        'postal_code',
        'phone',
        'email',
        'latitude',
        'longitude',
        'is_active',
        'is_default',
        'notes',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public $timestamps = true;

    /**
     * Get the display name based on current locale.
     */
    public function getDisplayNameAttribute(): string
    {
        if (app()->getLocale() === 'ar' && $this->name_ar) {
            return $this->name_ar;
        }
        return $this->name;
    }

    /**
     * Get the branch vendor (user).
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: only active branches.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope: only inactive branches.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    /**
     * Scope: only default branch.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }

    /**
     * Set this branch as default (unset others first).
     */
    public function setAsDefault(): void
    {
        self::where('user_id', $this->user_id)->update(['is_default' => 0]);
        $this->update(['is_default' => 1]);
    }
}
