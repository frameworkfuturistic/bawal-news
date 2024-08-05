<?php

namespace App\Models;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements BannableContract, MustVerifyEmail
{
    use HasFactory, Notifiable, Bannable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'occupation',
        'about',
        'links',
        'darkmode',
        'language',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * @return BelongsTo
     */
    public function userLanguage()
    {
        return $this->belongsTo(Language::class, 'language');
    }

    /**
     * @return string
     */
    public function adminlte_image()
    {
        return Auth::user()->photo ? asset('storage/avatar/' . Auth::user()->photo) : asset('img/noavatar.png');
    }

    /**
     * @return mixed
     */
    public function adminlte_desc()
    {
        return Auth::user()->roles->pluck('name')->implode(', ');
    }

    /**
     * @return string
     */
    public function adminlte_profile_url()
    {
        return 'admin/profile';
    }
}
