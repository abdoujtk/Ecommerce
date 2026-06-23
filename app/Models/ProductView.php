<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[fillable(['product_id', 'viewed_at', 'source'])]
class ProductView extends Model
{
  public $timestamps = false; // We don't use created_at/updated_at

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
