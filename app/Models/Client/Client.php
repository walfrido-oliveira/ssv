<?php

namespace App\Models\Client;

use App\Models\Budget\Budget;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'razao_social', 'nome_fantasia', 'im', 'ie', 'type',
        'home_page', 'description', 'adress', 'adress_number',
        'adress_district', 'adress_city', 'adress_state',
        'adress_cep', 'adress_comp', 'logo',  'activity_id',
        'client_id'
    ];


    /**
     * return a single Activity
     *
     * @return Activity
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * The budgets that belong to the client.
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }


}
