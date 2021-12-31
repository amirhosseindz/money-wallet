<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        if ($redirect = $this->handleFirstLogin()) {
            return $redirect;
        }

        return view('dashboard');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|null
     */
    private function handleFirstLogin()
    {
        $user = $this->getAuthenticatedUser();
        if ($user->first_login) {
            $user->firstLoginDone();

            return redirect(route('wallet.create'));
        }

        return null;
    }
}
