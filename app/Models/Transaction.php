<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Model
{
    use HasFactory;
    use TwoFactorAuthenticatable;

    public $timestamps = false;

    protected $fillable = [
        'from_user',
        'to_user',
        'from_account',
        'to_account',
        'description',
        'amount_from',
        'amount_to'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function account()
    {
        return $this->belongsToMany(Account::class);
    }

}
