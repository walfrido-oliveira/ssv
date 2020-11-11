<?php

namespace App\Models\Budget;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class BudgetProduct extends Model
{

    protected $table = "budget_product";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'index'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
        'index' => 'integer',
    ];

    /**
     * return a single Product
     *
     * @return Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
