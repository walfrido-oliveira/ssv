<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * The types that belong to the service.
     */
    public function service_types()
    {
        return $this->belongsToMany(ServiceType::class);
    }

    /**
     *
     * Get amount of services types
     */
    public function getAmount()
    {
        $amount = 0;
        $service_types = $this->service_types;

        foreach ($service_types as $value) {
            $amount += $value->price;
        }

        return $amount;
    }

}
