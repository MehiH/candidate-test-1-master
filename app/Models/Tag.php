<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['order_id', 'tag_id'];
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    public function order_tags()
    {
        return $this->hasMany(OrderTag::class);
    }
}
