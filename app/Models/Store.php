<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'store_name', 'phone', 'image'])]
class Store extends Model
{
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
