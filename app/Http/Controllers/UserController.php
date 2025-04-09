<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialGoal;
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
    $goals = FinancialGoal::where('user_id', Auth::id())
        ->orderBy('goal_year', 'asc')
        ->orderBy('goal_month', 'asc')
        ->get();
        
    return view('user.weekly-tracking', compact('goals'));
}

    public function reports()
    {
        return view('user.reports');
    }

}
