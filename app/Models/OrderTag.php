<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTag extends Model
{
    public function order()
    {
        return $this->belongsTo(OrderTag::class);
    }

    public function tag()
    {
        return $this->belongsTo(OrderTag::class);
    }
}
