<?php

namespace App\Models\Budget;

use App\Models\User;
use App\Models\Client\Client;
use App\Models\Product\Product;
use App\Models\Service\Service;
use Spatie\Sluggable\SlugOptions;
use App\Notifications\CreateBudget;
use App\Notifications\ApprovedBudget;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\DisapprovedBudget;
use Illuminate\Notifications\Notifiable;
use App\Models\Client\Contact\ClientContact;

class Budget extends Model
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'discount', 'validity', 'description', 'budget_type_id',
        'payment_method_id', 'transport_method_id', 'client_contact_id',
        'client_id', 'user_id', 'approved', 'approved_at', 'disapproved_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount'           => 'decimal:2',
        'discount'         => 'decimal:2',
        'validity'         => 'date:d-m-Y',
        'created_at'       => 'date:d-m-Y',
        'updated_at'       => 'date:d-m-Y',
        'approved'         => 'boolean',
        'approved_at'      => 'date:d-m-Y',
        'disapproved_at'   => 'date:d-m-Y',
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

    /**
     * The services that belong to the budget.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot('amount', 'index')
            ->orderBy('pivot_index');
    }

    /**
     * The products that belong to the budget.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('amount', 'index')
            ->orderBy('pivot_index');
    }

    /**
     *
     * Get amount of services types
     */
    public function getServiceAmountAttribute()
    {
        $amount = 0;
        $services = $this->services;

        foreach ($services as $value) {
            $amount += $value->price * $value->pivot->amount;
        }

        return $amount;
    }

    /**
     *
     * Get amount of products
     */
    public function getProductAmountAttribute()
    {
        $amount = 0;
        $products = $this->products;

        foreach ($products as $value) {
            $amount += $value->price * $value->pivot->amount;
        }

        return $amount;
    }

    /**
     * Get name Budget
     */
    public function getNameAttribute()
    {
        return '#' . $this->id . ' - ' . $this->client->nome_fantasia;
    }

    /**
     * Get formatted id
     */
    public function getFormattedIdAttribute()
    {
        return sprintf("%05d", $this->id);
    }

    /**
     * Send created notification for all users
     */
    public function sendCreatedBudget()
    {
        $users = $this->client->users;
        foreach ($users as $key => $user) {
            $user->sendCreatedBudget($this);
        }
    }

    /**
     * Send disapproved notification for all users
     */
    public function sendDisapprovedBudget()
    {
        $users = $this->client->users;
        foreach ($users as $key => $user) {
            $user->sendDisapprovedBudget($this);
        }
    }

    /**
     * Send approved notification for all users
     */
    public function sendApprovedBudget()
    {
        $users = $this->client->users;
        foreach ($users as $key => $user) {
            $user->sendApprovedBudget($this);
        }
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

        $budgets = $this->whereIn('client_id', $clients)->where('id', $id)->first();

        return !is_null($budgets);

    }

}
