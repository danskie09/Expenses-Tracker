<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialGoalWeeks extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'financial_goal_weeks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'goal_id',
        'week_number',
        'payable',
        'collection',
        'deficit',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'week_number' => 'integer',
        'payable' => 'decimal:2',
        'collection' => 'decimal:2',
        'deficit' => 'decimal:2',
    ];

    /**
     * Get the financial goal that owns the week.
     */
    public function financialGoal(): BelongsTo
    {
        return $this->belongsTo(FinancialGoal::class, 'goal_id');
    }
    
    /**
     * Get the breakdowns for this week.
     */
    public function breakdowns(): HasMany
    {
        return $this->hasMany(FinancialGoalBreakdown::class, 'week_id');
    }
    
    /**
     * Calculate deficit on save
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($week) {
            if (isset($week->collection) && isset($week->payable)) {
                $week->deficit = $week->collection - $week->payable;
            }
        });
    }
    
    /**
     * Get the total breakdown amount
     */
    public function getTotalBreakdownAmountAttribute()
    {
        return $this->breakdowns->sum('amount') ?: 0;
    }
}