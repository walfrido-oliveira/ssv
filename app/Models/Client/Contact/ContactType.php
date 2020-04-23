<?php

namespace App\Models\Client\Contact;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

}
