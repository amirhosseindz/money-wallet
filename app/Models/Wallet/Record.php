<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
