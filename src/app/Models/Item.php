<?php

namespace App\Models;

use Database\Seeders\ConditionsTableSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'seller_id',
        'name',
        'price',
        'brand',
        'description',
        'item_category_id',
        'image_url',
        'sales_flg',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class, 'condition_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
