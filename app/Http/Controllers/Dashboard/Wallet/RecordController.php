<?php

namespace App\Http\Controllers\Dashboard\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreRecordRequest;
use App\Models\Wallet\Record;
use App\Models\Wallet\Wallet;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wallets = Wallet::getLatest();
        $selectedWallet = $this->getSelectedWallet($request, $wallets);

        return view('dashboard.wallet.record.index', [
            'wallets' => $wallets,
            'selectedWalletId' => $selectedWallet->id,
            'records' => $selectedWallet->records()->latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.wallet.record.create', [
            'wallets' => Wallet::getLatest(),
            'types'   => Record::TYPES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecordRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRecordRequest $request)
    {
        $walletId = $request->input('wallet_id');

        try {
            Record::createRecord(
                $walletId, $request->input('type'), $request->input('amount')
            );
        } catch (\Exception $exception) {
            return redirect()->back()->with('record_error', $exception->getMessage());
        }

        return redirect(route('record.index', ['wallet_id' => $walletId]))
                ->with('record_success', true);
    }

    private function getSelectedWallet(Request $request, $wallets): Wallet
    {
        $selectedWallet = null;
        if ($walletId = $request->query('wallet_id')) {
            $selectedWallet = $wallets->where('id', (int)$walletId)->first();
        }
        if (! $selectedWallet) {
            $selectedWallet = $wallets->first();
        }

        return $selectedWallet;
    }
}
