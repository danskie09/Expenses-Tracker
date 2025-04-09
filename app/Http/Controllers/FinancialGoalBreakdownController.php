<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoalBreakdown;
use App\Models\FinancialGoalWeeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FinancialGoalBreakdownController extends Controller
{
    /**
     * Store a newly created breakdown
     */
    public function store(Request $request)
    {
        Log::info('Breakdown store method called', $request->all());
        
        $validator = Validator::make($request->all(), [
            'week_id' => 'required|exists:financial_goal_weeks,id',
            'description' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            Log::error('Breakdown validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verify the week belongs to the current user's goal
        try {
            $week = FinancialGoalWeeks::with('financialGoal')
                ->whereHas('financialGoal', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($request->week_id);
                
            Log::info('Week found', ['week' => $week->toArray()]);
        } catch (\Exception $e) {
            Log::error('Week not found or not authorized', ['exception' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'errors' => ['week_id' => ['Invalid week or unauthorized access']]
            ], 422);
        }

        try {
            $breakdown = FinancialGoalBreakdown::create([
                'week_id' => $request->week_id,
                'description' => $request->description,
                'amount' => $request->amount,
            ]);
            
            Log::info('Breakdown created', ['breakdown' => $breakdown->toArray()]);

            return response()->json([
                'status' => true,
                'message' => 'Breakdown created successfully',
                'breakdown' => $breakdown
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating breakdown', ['exception' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'errors' => ['general' => ['Error creating breakdown: ' . $e->getMessage()]]
            ], 500);
        }
    }
    
    /**
     * Delete a specific breakdown
     */
    public function destroy($id)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error deleting breakdown', ['exception' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Error deleting breakdown: ' . $e->getMessage()
            ], 500);
        }
    }
}