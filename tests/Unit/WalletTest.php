<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet\Wallet;
use Tests\TestCase;

class WalletTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create()
    {
        $user = User::factory()->create();

        $wallet = Wallet::createWallet($user, 'wallet1', 'type1');

        $this->assertInstanceOf(Wallet::class, Wallet::find($wallet->id));
        $this->assertEquals('wallet1', $wallet->name);
        $this->assertEquals('type1', $wallet->type);
        $this->assertEquals($user->id, $wallet->user_id);
    }

    public function test_increase_balance()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->make();

        $this->assertEquals(0, $wallet->balance);

        $wallet->increaseBalance(5);

        $this->assertEquals(5, $wallet->balance);
    }

    public function test_decrease_balance()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->make();

        $this->assertEquals(0, $wallet->balance);

        $wallet->increaseBalance(15);
        $wallet->decreaseBalance(5);

        $this->assertEquals(15-5, $wallet->balance);
    }

    public function test_decrease_balance_fails()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->make();

        $this->assertEquals(0, $wallet->balance);

        $wallet->increaseBalance(15);
        try {
            $wallet->decreaseBalance(15.5);
        } catch (\Throwable $exception) {
        }

        $this->assertEquals(15, $wallet->balance);
    }
}
