<?php

namespace App\Models\Order;

use App\Models\User;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Budget\BudgetProduct;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'budget_product_id', 'product_id', 'user_id', 'description', 'index'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * return a single Order
     *
     * @return Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * return a single BudgetProduct
     *
     * @return BudgetProduct
     */
    public function budgetProduct()
    {
        return $this->belongsTo(BudgetProduct::class);
    }

    /**
     * return a single Product
     *
     * @return Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * return a single User
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
