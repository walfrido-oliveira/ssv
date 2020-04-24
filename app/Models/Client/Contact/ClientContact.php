<?php

namespace App\Models\Client\Contact;

use Illuminate\Support\Str;
use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact', 'department', 'phone', 'mobile_phone',
        'email', 'contact_type_id', 'client_id'
    ];

    /**
     * return a single ContactType
     *
     * @return ContactType
     */
    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
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
     * return full description of contact
     */
    public function getFullDescriptionAttribute()
    {
        return $this->contact . ' - ' . $this->email;
    }

}
