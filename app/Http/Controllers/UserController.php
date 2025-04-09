<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialGoal;
use App\Models\FinancialGoalWeeks;

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
        $goals = FinancialGoal::where('user_id', Auth::id())
            ->orderBy('goal_year', 'asc')
            ->orderBy('goal_month', 'asc')
            ->get();
            
        return view('user.reports', compact('goals'));
    }
    
    /**
     * Get weeks for a specific financial goal.
     */
    public function getGoalWeeks($goalId)
    {
        // Verify the goal belongs to the authenticated user
        $goal = FinancialGoal::where('id', $goalId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $weeks = FinancialGoalWeeks::where('goal_id', $goalId)
            ->orderBy('week_number', 'asc')
            ->get();
            
        return response()->json(['weeks' => $weeks]);
    }
}
