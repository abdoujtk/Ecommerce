<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[fillable([
        'product_id', 'store_id', 'customer_name', 'customer_phone',
        'customer_address', 'customer_note', 'status', 'rating_code'
    ])]
class Order extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
