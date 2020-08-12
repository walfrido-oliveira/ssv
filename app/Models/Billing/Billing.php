<?php

namespace App\Models\Billing;

use App\Models\User;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\TransactionPayment;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'budget_id', 'client_id', 'payment_method_id', 'due_date',
        'created_at', 'amount', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get formatted id
     */
    public function getFormattedIdAttribute()
    {
        return sprintf("%05d", $this->id);
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

    /**
     * return a single TransactionPayment
     *
     * @return TransactionPayment
     */
    public function transactionPayments()
    {
        return $this->hasMany(TransactionPayment::class);
    }

    /**
     * return a single Budget
     *
     * @return Budget
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * Check if client user has acess to budget
     *
     * @param  int  $id
     *
     * @return boolean
     */
    public function checkClient($id)
    {
        $clients = User::getClientsId();

        $billings = $this->whereIn('client_id', $clients)->where('id', $id)->first();

        return !is_null($billings);

    }
}
