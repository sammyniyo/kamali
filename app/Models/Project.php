<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'year',
        'category',
        'status',
        'cover_image',
        'gallery',
        'featured',
        'sort_order',
        'architect_name',
        'client_name',
        'surface_area',
    ];

    protected $casts = [
        'gallery' => 'array',
        'featured' => 'boolean',
        'year' => 'integer',
        'surface_area' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (blank($project->slug) && filled($project->title)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}
