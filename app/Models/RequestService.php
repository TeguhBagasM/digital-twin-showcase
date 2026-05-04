<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestService extends Model
{
    use HasFactory;

    protected $fillable = [
        'showcase_id',
        'user_id',
        'serial_number',
        'description',
        'status',
    ];

    public function showcase(): BelongsTo
    {
        return $this->belongsTo(Showcase::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}