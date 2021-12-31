<?php

namespace App\Models;

use App\Models\Wallet\Wallet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read string $id
 * @property string  $name
 * @property string  $email
 * @property string  $fb_id
 * @property boolean $first_login
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fb_id',
        'first_login'
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

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public static function findByFacebookId(string $id): ?self
    {
        return self::where('fb_id', $id)->first();
    }

    public static function createByFacebookId(string $name, string $email, string $facebookId): self
    {
        return self::create([
            'name'     => $name,
            'email'    => $email,
            'fb_id'    => $facebookId,
            'password' => encrypt(Str::random())
        ]);
    }

    public function firstLoginDone(): void
    {
        if (! $this->first_login) {
            return;
        }

        $this->first_login = false;
        $this->save();
    }
}
