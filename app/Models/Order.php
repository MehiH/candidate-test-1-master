<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = ['customer_id', 'title', 'description', 'cost'];
    public function customer()
    {
        return $this->belongsTo(Order::class);
    }
    public function order_tags()
    {
        return $this->hasMany(OrderTag::class);
    }
}
