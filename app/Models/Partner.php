<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    /** @use HasFactory<\Database\Factories\PartnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'note',
        'url',
        'logo',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Partner $partner) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
        });
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }
}
