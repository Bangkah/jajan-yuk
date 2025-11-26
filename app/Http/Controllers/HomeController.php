<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService; // ← Import dari Services
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected RecommendationService $recommendationService
    ) {}

    public function index()
{
    $menus = Menu::where('is_available', true)
        ->with(['category', 'promos']) 
        ->paginate(12);

    $recommendations = app(RecommendationService::class)->getRecommendations();

    return view('user.home', compact('menus', 'recommendations'));
}
}