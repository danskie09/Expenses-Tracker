<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinancialGoalController extends Controller
{
    /**
     * Display a listing of financial goals.
     */
    public function index()
    {
        $goals = FinancialGoal::where('user_id', Auth::id())
            ->orderBy('goal_year', 'asc')
            ->orderBy('goal_month', 'asc')
            ->get();
        
        return view('user.financial-goal', compact('goals'));
    }

    /**
     * Store a newly created financial goal.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:0',
            'goal_month' => 'required|string|max:20',
            'goal_year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $goal = FinancialGoal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'goal_month' => $request->goal_month,
            'goal_year' => $request->goal_year,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Financial goal created successfully',
            'goal' => $goal
        ]);
    }

    /**
     * Display the specified financial goal.
     */
    public function show($id)
    {
        $goal = FinancialGoal::with('weeks.breakdowns')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return response()->json([
            'status' => true,
            'goal' => $goal
        ]);
    }

    /**
     * Update the specified financial goal.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:0',
            'goal_month' => 'required|string|max:20',
            'goal_year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($id);
        
        $goal->update([
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'goal_month' => $request->goal_month,
            'goal_year' => $request->goal_year,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Financial goal updated successfully',
            'goal' => $goal
        ]);
    }

    /**
     * Remove the specified financial goal.
     */
    public function destroy($id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($id);
        $goal->delete();

        return response()->json([
            'status' => true,
            'message' => 'Financial goal deleted successfully'
        ]);
    }
}
