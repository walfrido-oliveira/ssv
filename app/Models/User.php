<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Support\Str;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use Spatie\Sluggable\HasSlug;
use App\Notifications\Welcome;
use App\Models\Billing\Billing;
use Spatie\Sluggable\SlugOptions;
use App\Notifications\CreateOrder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Notifications\CreateBudget;
use App\Notifications\CreateBilling;
use App\Notifications\ResetPassword;
use App\Notifications\ApprovedBudget;
use App\Notifications\ApprovedPayment;
use App\Notifications\InProcessPayment;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DisapprovedBudget;
use Illuminate\Notifications\Notifiable;
use App\Notifications\DisapprovedPayment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles as HasRole;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRole;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Get url imagem from user profile
     *
     * @return string
     */
    public  function adminlte_image()
    {
        if (Storage::disk('public')->exists($this->profile_image))
        {
            return Storage::url($this->profile_image);
        } else {
            return Storage::url('img/empty_user.png');
        }
    }

    /**
     *
     * Get user desc
     *
     * @return string
     */
    public function adminlte_desc()
    {
        return $this->getType() == 'Admin' ? __('Administrator') : __('User');
    }

    /** Get type user: Admin or User
     *
     * @return string
    */
    public function getType()
    {
        if ($this->hasRole("Admin"))
        {
            return 'Admin';
        }
        else {
            return 'User';
        }
    }

    /**
     * Check if user is admin or not
     *
     * @return Boolean
     */
    public function isAdmin()
    {
        return $this->getType() === 'Admin';
    }

    /**
     * Check if user is user type or not
     *
     * @return Boolean
     */
    public function isUser()
    {
        return $this->getType() === 'User';
    }

    /**
     * Get clients array
     *
     * @return array
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    /**
     * Get all ids client for current user
     *
     * @return array
     */
    public static function getClientsId()
    {
        return auth()->user()->clients()->pluck('client_user.client_id');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
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

    /**
     * Send Welcome mail to newly user
     */
    public function sendWelcomeEmail(){

        $token = app('auth.password.broker')->createToken($this);;

        DB::table(config('auth.passwords.users.table'))->insert([
            'email' => $this->email,
            'token' => $token
        ]);

        $url = url(config('app.url').route('password.reset', [
            'token' => $token,
            'email' =>  $this->email,
        ], false));

        $this->notify(new Welcome($this, $url));

    }

    /**
     * Send created budget mail
     *
     * @param Budget $budget
     */
    public function sendCreatedBudget($budget)
    {
        if ($this->isUser()) $this->notify(new CreateBudget($budget));
    }

    /**
     * Send disapproved budget mail
     *
     * @param Budget $budget
     */
    public function sendDisapprovedBudget($budget)
    {
        if ($this->isAdmin()) $this->notify(new DisapprovedBudget($budget));
    }

    /**
     * Send approved budget mail
     *
     * @param Budget $budget
     */
    public function sendApprovedBudget($budget)
    {
        if ($this->isAdmin()) $this->notify(new ApprovedBudget($budget));
    }

    /**
     * Send created order mail
     *
     * @param Order $order
     */
    public function sendCreatedOrder($order)
    {
        if ($this->isUser()) $this->notify(new CreateOrder($order));
    }

    /**
     * Send created billing mail
     *
     * @param Billing $billing
     */
    public function sendCreatedBilling($billing)
    {
        if ($this->isUser()) $this->notify(new CreateBilling($billing));
    }

    /**
     * Send approved payment mail
     *
     * @param Billing $billing
     */
    public function sendApprovedPayment($billing)
    {
        if ($this->isUser()) $this->notify(new ApprovedPayment($billing));
    }

    /**
     * Send disapproved payment mail
     *
     * @param Billing $billing
     */
    public function sendDisapprovedPayment($billing)
    {
        if ($this->isUser()) $this->notify(new DisapprovedPayment($billing));
    }

    /**
     * Send in process payment mail
     *
     * @param Billing $billing
     */
    public function sendInProcessdPayment($billing)
    {
        if ($this->isUser()) $this->notify(new InProcessPayment($billing));
    }

    /**
     * Get roles from a user
     *
     * @return array
     */
    public function getRoles() {
        $roles = Role::pluck('name', 'name')->all();
        $rolesTemp;
        foreach ($roles as $key => $role) {
            $rolesTemp[$key] = __($role);
        }
        return $rolesTemp;
    }

     /**
     * Get formatted roles from a user
     *
     * @return array
     */
    public function getRolesFormrtted() {
        $roles = $this->roles->pluck('name', 'name')->all();
        $rolesTemp;
        foreach ($roles as $key => $role) {
            $rolesTemp[$key] = __($role);
        }
        return implode(', ', $rolesTemp);
    }
}
