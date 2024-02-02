<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends FrontendController
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return View('frontend.home.index');
    }
}
