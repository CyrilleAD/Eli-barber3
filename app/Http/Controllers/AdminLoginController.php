<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function show()
    {
        if(session()->get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'pin' => 'required|string',
        ]);

        $configuredPin = env('ADMIN_PIN');

        if ($request->pin === $configuredPin) {
            session()->put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withError(['pin' => 'PIN admin incorrect, veuillez réessayer']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login.show')->withSuccess('Déconnecté avec succès');
    }
}
