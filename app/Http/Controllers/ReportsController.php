<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FinancialGoal;
use App\Models\FinancialGoalWeeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $user = Auth::user();
        
        // Get all financial goals for the user for the selected year
        $goals = FinancialGoal::where('user_id', $user->id)
            ->where('goal_year', $year)
            ->with('weeks')
            ->get();
            
        // Get all weeks for financial goals of the year
        $weeks = FinancialGoalWeeks::whereHas('financialGoal', function($query) use ($user, $year) {
            $query->where('user_id', $user->id)
                ->where('goal_year', $year);
        })->with('financialGoal')
        ->orderBy('week_number')
        ->get();
        
        // Calculate totals
        $totalCollection = $goals->sum('total_collection');
        $totalPayable = $goals->sum(function($goal) {
            return $goal->weeks->sum('payable');
        });
        $totalDeficit = $goals->sum('total_deficit');
        
        return view('user.reports', compact(
            'goals', 
            'weeks', 
            'totalCollection', 
            'totalPayable', 
            'totalDeficit',
            'year'
        ));
    }
}
