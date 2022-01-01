<?php

namespace Database\Factories\Wallet;

use App\Models\User;
use App\Models\Wallet\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->creditCardType(),
            'user_id' => User::factory(),
        ];
    }

    public function modelName()
    {
        return Wallet::class;
    }
}
