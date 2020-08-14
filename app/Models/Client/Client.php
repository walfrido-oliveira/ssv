<?php

namespace App\Models\Client;

use App\Models\User;
use App\Models\Budget\Budget;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client\Contact\ClientContact;

class Client extends Model
{

    use HasSlug;

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
        'client_id', 'created_at', 'updated_at', 'status'
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

    /**
     * The contacts that belong to the client.
     */
    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }

    /**
     * Get users
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get image profile
     */
    public function getImageAttribute()
    {
        return !is_null($this->logo) ? 'storage/' . $this->logo : 'storage/img/empty_user.png';
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome_fantasia')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
