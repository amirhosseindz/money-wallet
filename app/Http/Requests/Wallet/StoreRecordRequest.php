<?php

namespace App\Http\Requests\Wallet;

use App\Models\Wallet\Record;

class StoreRecordRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wallet_id' => 'required|exists:wallets,id',
            'type'      => 'required|in:' . implode(',', Record::TYPES),
            'amount'    => 'required|numeric|gt:0'
        ];
    }
}
