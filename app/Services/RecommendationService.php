<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    public function getRecommendations()
    {
        $now = now();
        $hour = $now->hour;
        $today = $now->toDateString();

        // 1. Top 5 menu paling sering dipesan
        $topMenuIds = DB::table('order_items')
            ->select('menu_id', DB::raw('SUM(qty) as total_sold'))
            ->whereNotNull('menu_id')
            ->groupBy('menu_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->pluck('menu_id');

        $topMenus = collect();
        if ($topMenuIds->isNotEmpty()) {
            $topMenus = Menu::with(['category', 'promos'])
                ->whereIn('id', $topMenuIds)
                ->get()
                ->sortByDesc(fn($menu) => $topMenuIds->search($menu->id))
                ->values();
        }

        // 2. Promo aktif hari ini
        $activePromos = Promo::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->with('menu')
            ->get();

        // 3. Rekomendasi berdasarkan waktu
        $timeBasedMenus = collect();
        $categoryId = null;

        if ($hour >= 5 && $hour < 11) {
            $categoryId = Category::where('name', 'like', '%kopi%')
                ->orWhere('name', 'like', '%sarapan%')
                ->first()?->id;
        } elseif ($hour >= 11 && $hour < 18) {
            $categoryId = Category::where('name', 'like', '%makanan%')
                ->orWhere('name', 'like', '%berat%')
                ->first()?->id;
        } else {
            $categoryId = Category::where('name', 'like', '%mie%')
                ->orWhere('name', 'like', '%malam%')
                ->first()?->id;
        }

        if ($categoryId) {
            $timeBasedMenus = Menu::where('category_id', $categoryId)
                ->where('is_available', true)
                ->with(['category', 'promos']) // ✅ eager load promos
                ->limit(4)
                ->get();
        }

        return [
            'top' => $topMenus,
            'promo' => $activePromos,
            'time_based' => $timeBasedMenus,
            'is_morning' => $hour >= 5 && $hour < 11,
            'is_night' => $hour >= 18,
        ];
    }
}