<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Webmozart\Assert\Assert;

/**
 * @property-read int    $id
 * @property      int    $wallet_id
 * @property      string $type
 * @property      float  $amount
 */
class Record extends Model
{
    use HasFactory;

    public const TYPE_CREDIT = 'Credit';
    public const TYPE_DEBIT = 'Debit';
    public const TYPES = [self::TYPE_CREDIT, self::TYPE_DEBIT];

    protected $fillable = [
        'wallet_id',
        'type',
        'amount'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public static function createRecord(int $walletId, string $type, float $amount): self
    {
        $wallet = Wallet::find($walletId);
        if (! $wallet) {
            throw new \InvalidArgumentException('Invalid Wallet id');
        }

        Assert::oneOf($type, self::TYPES, 'Invalid Record type');
        Assert::greaterThan($amount, 0, 'Invalid Amount');

        return DB::transaction(function () use ($wallet, $type, $amount) {
            $record = self::create([
                'wallet_id' => $wallet->id,
                'type'      => $type,
                'amount'    => $amount
            ]);
            if (! $record instanceof Record) {
                throw new \Exception('Could not persist the record');
            }

            if ($record->isCredit()) {
                $wallet->increaseBalance($amount);
            } elseif($record->isDebit()) {
                $wallet->decreaseBalance($amount);
            } else {
                throw new \Exception('Unknown Record type');
            }

            return $record;
        });
    }

    public function isCredit(): bool
    {
        return $this->type === self::TYPE_CREDIT;
    }

    public function isDebit(): bool
    {
        return $this->type === self::TYPE_DEBIT;
    }
}
