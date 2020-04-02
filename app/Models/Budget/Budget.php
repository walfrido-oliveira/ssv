<?php

namespace App\Models\Budget;

use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client\Contact\ClientContact;

class Budget extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'discount', 'validity', 'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount'     => 'decimal:2',
        'discount'   => 'decimal:2',
        'validity'   => 'date:d-m-Y',
        'created_at' => 'date:d-m-Y',
        'updated_at' => 'date:d-m-Y',
    ];

    /**
     * return a single BudgetType
     *
     * @return BudgetType
     */
    public function budgetType()
    {
        return $this->belongsTo(BudgetType::class);
    }

    /**
     * return a single PaymentMethod
     *
     * @return PaymentMethod
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * return a single TransportMethod
     *
     * @return TransportMethod
     */
    public function transportMethod()
    {
        return $this->belongsTo(TransportMethod::class);
    }

    /**
     * return a single ClientContact
     *
     * @return ClientContact
     */
    public function clientContact()
    {
        return $this->belongsTo(ClientContact::class);
    }

    /**
     * return a single Client
     *
     * @return Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
