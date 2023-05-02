<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Lauthz\Facades\Enforcer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['permissions', 'role'];

    public function getPermissionsAttribute()
    {
        $one = collect(Enforcer::getRolesForUser($this->id))->map(function($group) {
            return ['g', $this->id, $group];
        });

        $two = collect(Enforcer::getRolesForUser($this->id))->reduce(function($result, $role) {
            return $result->merge(collect(Enforcer::getRolesForUser($role))->reduce(function($res, $val) use ($role){
                $res[] = ['g', $role, $val];
                return $res;
            }, []));
        }, collect([]));

        return collect(Enforcer::getImplicitPermissionsForUser($this->id))->map(function($policy) {
            array_unshift($policy, 'p');
            return $policy;
        })->merge($one)->merge($two);

    }

    /**
     * @return HasMany
     */
    public function providers(): HasMany
    {
        return $this->hasMany(SocialProvider::class)->orderBy('created_at');
    }

    public function getRoleAttribute()
    {
        return Enforcer::getRolesForUser($this->id)[0];
    }
}
