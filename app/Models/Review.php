<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


#[fillable(['order_id', 'product_id', 'store_id', 'rating', 'comment'])]
class Review extends Model
{
     public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
