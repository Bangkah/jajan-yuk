<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    /** @use HasFactory<\Database\Factories\PromoFactory> */
    use HasFactory;

     protected $fillable = ['title', 'description', 'discount_percent', 'applied_menu_id', 'start_date', 'end_date'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'applied_menu_id');
    }
}
