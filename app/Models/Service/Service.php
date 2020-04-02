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
    public function serviceTypes()
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
        $serviceTypes = $this->serviceTypes;

        foreach ($serviceTypes as $value) {
            $amount += $value->price;
        }

        return $amount;
    }

}
