<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialGoal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'target_amount',
        'goal_month',
        'goal_year',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'target_amount' => 'decimal:2',
        'goal_year' => 'integer',
    ];

    /**
     * Get the user that owns the financial goal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the weeks for the financial goal.
     */
    public function weeks(): HasMany
    {
        return $this->hasMany(FinancialGoalWeeks::class, 'goal_id');
    }
    
    /**
     * Calculate progress percentage based on collections
     * 
     * @return float|null
     */
    public function getProgressPercentageAttribute()
    {
        if (!$this->target_amount) {
            return null;
        }
        
        $totalCollected = $this->weeks->sum('collection') ?: 0;
        return min(100, ($totalCollected / $this->target_amount) * 100);
    }
    
    /**
     * Get the total collection amount
     */
    public function getTotalCollectionAttribute()
    {
        return $this->weeks->sum('collection') ?: 0;
    }
    
    /**
     * Get the total deficit amount
     */
    public function getTotalDeficitAttribute()
    {
        return $this->weeks->sum('deficit') ?: 0;
    }
}