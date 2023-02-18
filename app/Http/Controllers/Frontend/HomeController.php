<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Backend\Tender;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tender_data = Tender::orderByDesc('id')->where('status', 'running')->get();
        return view('frontend.pages.home', compact('tender_data'));
    }
}
