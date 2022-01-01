<?php

namespace App\Models\Wallet;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webmozart\Assert\Assert;

/**
 * @property-read int    $id
 * @property      int    $user_id
 * @property      string $name
 * @property      string $type
 * @property      float  $balance
 *
 * @method static self find(int $id)
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public static function createWallet(User $user, string $name, string $type): self
    {
        return self::create([
            'user_id' => $user->id,
            'name' => $name,
            'type' => $type
        ]);
    }

    public static function getLatest()
    {
        return self::query()->latest()->get();
    }

    public static function getTotalBalance(): float
    {
        return self::query()->sum('balance');
    }

    public function increaseBalance(float $amount): void
    {
        $this->changeBalance($amount);
    }

    public function decreaseBalance(float $amount): void
    {
        $this->changeBalance($amount, true);
    }

    private function changeBalance(float $amount, bool $decrease = false): void
    {
        Assert::greaterThan($amount, 0, 'Invalid Amount');

        if ($decrease) {
            $amount = -1 * $amount;
        }

        $this->balance += $amount;
        if ($this->balance < 0) {
            $this->balance -= $amount;
            throw new \InvalidArgumentException('Balance is not enough');
        }

        if (! $this->save()) {
            throw new \Exception('Could not persist the balance');
        }
    }
}
