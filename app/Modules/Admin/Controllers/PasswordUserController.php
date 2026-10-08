<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class PasswordUserController extends Controller
{

    public function index(Request $request): String
    {
        return view('Admin.Views.password');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\UpdatesUserPasswords  $updater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->all());
        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $request->wantsJson()
            ? new JsonResponse(['code' => 0], 200)
            : back()->with('status', 'password-updated');
    }
}
