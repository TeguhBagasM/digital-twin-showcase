<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Showcase extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'user_id',
        'warranty_expired_at',
        'compressor_type',
        'glass_spec',
    ];

    protected function casts(): array
    {
        return [
            'warranty_expired_at' => 'date',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Warranty status accessor.
     * Returns "Aktif" if warranty is still valid, "Kedaluwarsa" if expired.
     */
    protected function warrantyStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::now()->lessThan($this->warranty_expired_at)
                ? 'Aktif'
                : 'Kedaluwarsa',
        );
    }

    /**
     * Check if warranty is active (boolean helper).
     */
    protected function isWarrantyActive(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::now()->lessThan($this->warranty_expired_at),
        );
    }
}
