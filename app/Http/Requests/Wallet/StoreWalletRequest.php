<?php

namespace App\Http\Requests\Wallet;

class StoreWalletRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255'
        ];
    }
}
