<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    /** @use HasFactory<\Database\Factories\PlantFactory> */
    use HasFactory;
    protected $fillable = [
    'name', 'scientific_name', 'family', 'genus', 'order_name', 'class_name', 'origin', 'type',
    'water', 'light', 'temperature', 'humidity', 'soil', 'fertilizer', 'repotting', 'pruning', 'propagation',
    'growth_type', 'max_height', 'flowering_season', 'leaf_type', 'leaf_color', 'flower_color',
    'toxicity', 'difficulty',
    'description', 'short_description',
    'min_price', 'max_price', 'is_available',
    'featured_image', 'gallery_images',
    'qr_code_path', 'qr_code_url', 'views_count',
    'slug', 'meta_title', 'meta_description', 'meta_keywords'
];
    protected $casts = [
            'gallery_images' => 'array',
    ];
}
