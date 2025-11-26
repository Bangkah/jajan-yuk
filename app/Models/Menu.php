<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

     protected $fillable = ['category_id', 'name', 'description', 'price', 'image', 'is_available'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class, 'applied_menu_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
