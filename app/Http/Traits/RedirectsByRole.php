<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait RedirectsByRole
{
    protected function redirectBasedOnRole(User $user)
    {
        return match ($user->role) {
            'customer' => redirect()->route('customer.dashboard'),

            'provider' => redirect()->route('provider.dashboard'),

            'admin' => redirect()->route('admin.dashboard'),

            default => tap(
                redirect()->route('login'),
                fn () => Auth::logout()
            )->withErrors([
                'email' => 'Your account has an invalid role.',
            ]),
        };
    }
}