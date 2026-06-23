<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


#[fillable(['name', 'parent_id', 'image'])]
class Category extends Model
{
     public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
