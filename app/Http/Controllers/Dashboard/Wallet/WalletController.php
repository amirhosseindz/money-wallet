<?php

namespace App\Http\Controllers\Dashboard\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreWalletRequest;
use App\Models\Wallet\Wallet;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.wallet.index', [
            'wallets' => Wallet::getLatest(),
            'totalBalance' => Wallet::getTotalBalance()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWalletRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreWalletRequest $request)
    {
        Wallet::createWallet(
            $this->getAuthenticatedUser(),
            $request->input('name'),
            $request->input('type')
        );

        return redirect(route('wallet.index'))->with('wallet_success', true);
    }
}
