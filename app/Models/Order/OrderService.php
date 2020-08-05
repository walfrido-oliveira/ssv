<?php

namespace App\Models\Order;

use App\Models\User;
use App\Models\Order\Order;
use App\Models\Service\Service;
use App\Models\Budget\BudgetService;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'budget_service_id', 'service_id', 'user_id', 'service_type_id',
        'executed_at', 'equipment_id', 'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'executed_at'      => 'date:d-m-Y',
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
     * return a single BudgetService
     *
     * @return BudgetService
     */
    public function budgetService()
    {
        return $this->belongsTo(BudgetService::class);
    }

    /**
     * return a single Service
     *
     * @return Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
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

    /**
     * return a single ServiceType
     *
     * @return ServiceType
     */
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
