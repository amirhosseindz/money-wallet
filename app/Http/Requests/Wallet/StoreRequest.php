<?php

namespace App\Http\Requests\Wallet;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

abstract class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var User|null $user */
        $user = $this->user();
        if (! $user) {
            return false;
        }

        return $user->hasVerifiedEmail();
    }
}
