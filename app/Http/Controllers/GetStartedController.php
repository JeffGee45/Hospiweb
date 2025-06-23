<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GetStartedController extends Controller
{
    /**
     * Display the get started page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('get-started');
    }

    /**
     * Mark the get started process as complete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request)
    {
        $request->session()->put('get_started_completed', true);
        return redirect()->route('dashboard');
    }
}
