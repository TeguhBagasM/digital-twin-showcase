<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'image',
    ];

    protected function casts(): array
    {
        return [
            'warranty_expired_at' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'serial_number';
    }

    public function imageUrl(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        return asset('images/' . $this->image);
    }

    public function image_url(): ?string
    {
        return $this->imageUrl();
    }

    public static function generateSerialNumber(): string
    {
        $year = now()->year;
        $prefix = 'HC-' . $year . '-';

        $lastSerialNumber = static::query()
            ->where('serial_number', 'like', $prefix . '%')
            ->orderByDesc('serial_number')
            ->value('serial_number');

        $nextSequence = 1;

        if ($lastSerialNumber) {
            $parts = explode('-', $lastSerialNumber);
            $lastSequence = (int) ($parts[2] ?? 0);
            $nextSequence = $lastSequence + 1;
        }

        return $prefix . str_pad((string) $nextSequence, 3, '0', STR_PAD_LEFT);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requestServices(): HasMany
    {
        return $this->hasMany(RequestService::class);
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
