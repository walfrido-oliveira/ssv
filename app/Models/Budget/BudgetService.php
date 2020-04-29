<?php

namespace App\Models\Budget;

use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;

class BudgetService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
    ];

    /**
     * return a single Client
     *
     * @return Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     *
     * Get amount of budget
     */
    public function getTotalAttribute()
    {
        dd('www');
        return $this->amount * $this->service->price;
    }
}
