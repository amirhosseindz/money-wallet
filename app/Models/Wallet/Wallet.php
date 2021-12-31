<?php

namespace App\Models\Wallet;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createWallet(User $user, string $name, string $type): self
    {
        return self::create([
            'user_id' => $user->id,
            'name' => $name,
            'type' => $type
        ]);
    }
}
