<?php

namespace App\Models;

use App\Auth\ServiceAuthenticatable;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Services extends ServiceAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function findServiceExecutor($name = 'ServiceExecutor'){
        return $this->where('username', 'LIKE', $name.'%')->first();
    }

    public function findArticleService($name = 'ArticleService'){
        return $this->where('username', 'LIKE', $name.'%')->first();
    }
}
