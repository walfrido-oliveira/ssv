<?php

namespace App\Models\Order;

use App\Models\User;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\Order\OrderService;
use App\Notifications\CreateOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'budget_id', 'client_id', 'observation', 'status',
    ];

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
     * return a single Budget
     *
     * @return Budget
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * return a single Budget
     *
     * @return Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * The order that belong to the services.
     */
    public function services()
    {
        return $this->hasMany(OrderService::class);
    }

    /**
     * Get formatted id
     *
     * @return string
     */
    public function getFormattedIdAttribute()
    {
        return sprintf("%05d", $this->id);
    }

    /**
     * Send created order notification for all users
     */
    public function sendCreatedOrder()
    {
        $users = $this->client->users;
        foreach ($users as $key => $user) {
            $user->sendCreatedOrder($this);
        }
    }
}
