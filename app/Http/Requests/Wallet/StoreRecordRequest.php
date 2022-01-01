<?php

namespace App\Http\Requests\Wallet;

use App\Models\Wallet\Record;
use App\Models\Wallet\Wallet;

class StoreRecordRequest extends StoreRequest
{
    public function authorize()
    {
        if (! parent::authorize()) {
            return false;
        }
        if (($walletId = $this->input('wallet_id')) &&
            $this->user()->id !== Wallet::getUserId($walletId)
        ) {
            return false;
        }

        return true;
    }

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
