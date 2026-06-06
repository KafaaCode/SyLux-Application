<?php

namespace App\Http\Controllers;

use App\Services\Front\HomeService;

class HomeController extends Controller
{
    public function index(HomeService $homeService)
    {
        return view('welcome', $homeService->getHomePageData());
    }
}
