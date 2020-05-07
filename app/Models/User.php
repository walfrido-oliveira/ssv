<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles as HasRole;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRole;

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

    public  function adminlte_image()
    {
        if (Storage::disk('public')->exists($this->profile_image))
        {
            return Storage::url($this->profile_image);
        } else {
            return Storage::url('img/empty_user.png');
        }
    }

    public function adminlte_desc()
    {
        return $this->getType() == 'Admin' ? __('Administrator') : __('User');
    }

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

    public function isAdmin()
    {
        return $this->getType() === 'Admin';
    }
}
