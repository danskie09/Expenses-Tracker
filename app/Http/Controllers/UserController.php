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
    public function getGoalWeeks($goalId, Request $request)
    {
        // Verify the goal belongs to the authenticated user
        $goal = FinancialGoal::where('id', $goalId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Start query
        $weeksQuery = FinancialGoalWeeks::where('goal_id', $goalId);
        
        // Apply month/year filter if provided
        $month = $request->input('month');
        $year = $request->input('year');
        
        if ($month && $year) {
            $weeksQuery->whereRaw('MONTH(updated_at) = ?', [$month])
                      ->whereRaw('YEAR(updated_at) = ?', [$year]);
        } else if ($month) {
            $weeksQuery->whereRaw('MONTH(updated_at) = ?', [$month]);
        } else if ($year) {
            $weeksQuery->whereRaw('YEAR(updated_at) = ?', [$year]);
        }
        
        // Get the weeks, ensuring they're in order
        $weeks = $weeksQuery->orderBy('week_number', 'asc')->get();
        
        return response()->json(['weeks' => $weeks]);
    }
}
