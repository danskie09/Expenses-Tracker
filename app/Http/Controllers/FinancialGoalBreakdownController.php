<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoalBreakdown;
use App\Models\FinancialGoalWeeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinancialGoalBreakdownController extends Controller
{
    /**
     * Store a newly created breakdown
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'week_id' => 'required|exists:financial_goal_weeks,id',
            'description' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verify the week belongs to the current user's goal
        $week = FinancialGoalWeeks::with('financialGoal')
            ->whereHas('financialGoal', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($request->week_id);

        $breakdown = FinancialGoalBreakdown::create([
            'week_id' => $request->week_id,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Breakdown created successfully',
            'breakdown' => $breakdown
        ]);
    }
    
    /**
     * Delete a specific breakdown
     */
    public function destroy($id)
    {
        // Find the breakdown and ensure it belongs to the current user's goal
        $breakdown = FinancialGoalBreakdown::with('week.financialGoal')
            ->whereHas('week.financialGoal', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        $breakdown->delete();

        return response()->json([
            'status' => true,
            'message' => 'Breakdown deleted successfully'
        ]);
    }
}