<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoal;
use App\Models\FinancialGoalWeeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinancialGoalWeekController extends Controller
{
    /**
     * Get all weeks for a specific goal
     */
    public function getWeeksByGoal($goalId)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($goalId);
        
        $weeks = FinancialGoalWeeks::where('goal_id', $goalId)
            ->orderBy('week_number', 'asc')
            ->get();
            
        return response()->json([
            'status' => true,
            'weeks' => $weeks
        ]);
    }
    
    /**
     * Get the next available week number for a goal
     */
    public function getNextWeekNumber($goalId)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($goalId);
        
        $maxWeekNumber = FinancialGoalWeeks::where('goal_id', $goalId)
            ->max('week_number');
            
        return response()->json([
            'next_week_number' => $maxWeekNumber ? $maxWeekNumber + 1 : 1
        ]);
    }
    
    /**
     * Get a specific week with its details
     */
    public function show($id)
    {
        $week = FinancialGoalWeeks::with('financialGoal')
            ->whereHas('financialGoal', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
            
        return response()->json([
            'status' => true,
            'week' => $week
        ]);
    }
    
    /**
     * Store a newly created week
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_id' => 'required|exists:financial_goals,id',
            'week_number' => 'required|integer|min:1|max:53',
            'payable' => 'required|numeric|min:0',
            'collection' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verify the goal belongs to the current user
        $goal = FinancialGoal::where('id', $request->goal_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        // Check if week number already exists for this goal
        $existingWeek = FinancialGoalWeeks::where('goal_id', $request->goal_id)
            ->where('week_number', $request->week_number)
            ->first();
            
        if ($existingWeek) {
            return response()->json([
                'status' => false,
                'errors' => ['week_number' => ['Week number already exists for this goal']]
            ], 422);
        }

        $week = FinancialGoalWeeks::create([
            'goal_id' => $request->goal_id,
            'week_number' => $request->week_number,
            'payable' => $request->payable,
            'collection' => $request->collection,
            'remarks' => $request->remarks,
            // deficit will be calculated automatically in the model's boot method
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Week created successfully',
            'week' => $week
        ]);
    }
    
    /**
     * Update a specific week
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payable' => 'required|numeric|min:0',
            'collection' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Find the week and ensure it belongs to the current user's goal
        $week = FinancialGoalWeeks::with('financialGoal')
            ->whereHas('financialGoal', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        $week->update([
            'payable' => $request->payable,
            'collection' => $request->collection,
            'remarks' => $request->remarks,
            // deficit will be updated automatically
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Week updated successfully',
            'week' => $week
        ]);
    }
    
    /**
     * Get all breakdowns for a specific week
     */
    public function getBreakdowns($weekId)
    {
        $week = FinancialGoalWeeks::with('financialGoal')
            ->whereHas('financialGoal', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($weekId);
            
        $breakdowns = $week->breakdowns;
            
        return response()->json([
            'status' => true,
            'breakdowns' => $breakdowns
        ]);
    }
}