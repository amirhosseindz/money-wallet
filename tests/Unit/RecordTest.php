<?php

namespace Tests\Unit;

use App\Models\Wallet\Record;
use App\Models\Wallet\Wallet;
use Tests\TestCase;

class RecordTest extends TestCase
{
    public function test_create_credit()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create(['balance' => 30]);

        $record = Record::createRecord($wallet->id, Record::TYPE_CREDIT, 20);
        $this->assertInstanceOf(Record::class, Record::find($record->id));
        $this->assertEquals(Record::TYPE_CREDIT, $record->type);
        $this->assertEquals(20, $record->amount);
        $this->assertEquals($wallet->id, $record->wallet_id);

        $wallet->refresh();
        $this->assertEquals(20, $wallet->balance - 30);
    }

    public function test_create_debit()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create(['balance' => 30]);

        $record = Record::createRecord($wallet->id, Record::TYPE_DEBIT, 20);
        $this->assertInstanceOf(Record::class, Record::find($record->id));
        $this->assertEquals(Record::TYPE_DEBIT, $record->type);
        $this->assertEquals(20, $record->amount);
        $this->assertEquals($wallet->id, $record->wallet_id);

        $wallet->refresh();
        $this->assertEquals(20, 30 - $wallet->balance);
    }

    public function test_create_debit_fails()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create(['balance' => 19]);

        $record = null;
        $recordCount = Record::query()->count();

        try {
            $record = Record::createRecord($wallet->id, Record::TYPE_DEBIT, 20);
        } catch (\Throwable $exception) {
        }

        $this->assertNull($record);
        $this->assertEquals($recordCount, Record::query()->count());

        $wallet->refresh();
        $this->assertEquals(19, $wallet->balance);
    }
}
