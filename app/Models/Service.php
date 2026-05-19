<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon_name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Service $service) {
            if (blank($service->slug) && filled($service->title)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }
}
