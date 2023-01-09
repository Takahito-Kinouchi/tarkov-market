<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'price_per_slot',
        'price_day_change',
        'price_week_change',
        'sell_to',
        'price_to_trader',
    ];

    public function itemHeader()
    {
        return $this->belongsTo(Item::class);
    }
}
