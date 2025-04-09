<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //


    public function index()
    {
        return view('user.index');
    }

    public function financialGoals()
    {
        return view('user.financial-goal');
    }

    public function weeklyTracking()
    {
        return view('user.weekly-tracking');
    }

    public function reports()
    {
        return view('user.reports');
    }

}
