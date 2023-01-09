<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'category_tags',
    ];

    public function itemDetails()
    {
        return $this->hasMany(ItemDetail::class);
    }
}
