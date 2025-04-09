<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialGoalBreakdown extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'week_id',
        'description',
        'amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the financial goal week that owns the breakdown.
     */
    public function week(): BelongsTo
    {
        return $this->belongsTo(FinancialGoalWeeks::class, 'week_id');
    }
    
    /**
     * Get the financial goal through the week.
     */
    public function financialGoal()
    {
        return $this->week->financialGoal;
    }
}