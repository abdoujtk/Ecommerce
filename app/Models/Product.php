<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'store_id',
    'category_id',
    'name',
    'description',
    'price',
    'view_count',
    'unique_link',
    'is_active',
])]

class Product extends Model
{
    use HasFactory;

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function views()
    {
        return $this->hasMany(ProductView::class);
    }
}