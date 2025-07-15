<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }

    public function send(Request $request)
    {
        return response()->json([
            'message' => 'Data received successfully',
            'data' => $request->all(),
        ]);
    }
}