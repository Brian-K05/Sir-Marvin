<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Feedback;

class HomeController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::approved()
            ->with(['submission.service', 'user'])
            ->latest()
            ->take(8)
            ->get();
        
        return view('public.home', compact('feedbacks'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
