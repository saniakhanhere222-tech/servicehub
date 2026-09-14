<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\RedirectsByRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    use RedirectsByRole;

    /**
     * Redirect the user to Google for authentication.
     */
    public function redirect(Request $request)
    {
        // Remember where Google authentication started (login vs register).
        if ($request->has('from')) {
            session(['google_from' => $request->from]);
        }

        // Remember the role selected on the Register page.
        if ($request->has('role') && in_array($request->role, ['customer', 'provider'])) {
            session(['google_role' => $request->role]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            return $this->handleExistingGoogleUser($user);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            return $this->handleExistingEmailUser($user, $googleUser);
        }

        return $this->createNewGoogleUser($googleUser);
    }

    /**
     * CASE 1: A user with this Google ID already exists.
     */
    private function handleExistingGoogleUser(User $user)
    {
        // If Google auth started from Register, don't silently log them in.
        if (session('google_from') === 'register') {
            session()->forget(['google_from', 'google_role']);

            return view('auth.google-account-choice', [
                'message' => 'You are already registered with this Google account. Please log in instead.',
                'canCreateAccount' => false,
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    /**
     * CASE 2: No matching Google ID, but the email already exists.
     */
    private function handleExistingEmailUser(User $user, $googleUser)
    {
        // Same email already linked to a different Google account.
        if ($user->google_id !== null) {
            session()->forget(['google_from', 'google_role']);

            return view('auth.google-account-choice', [
                'message' => 'This email is already connected to another Google account.',
                'canCreateAccount' => false,
            ]);
        }

        // Link this Google account to the existing email/password user.
        $user->google_id = $googleUser->getId();
        $user->save();

        if (session('google_from') === 'register') {
            session()->forget(['google_from', 'google_role']);

            return view('auth.google-account-choice', [
                'message' => 'You are already registered with this email. Please log in instead.',
                'canCreateAccount' => false,
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    /**
     * CASE 3: Completely new Google user.
     */
    private function createNewGoogleUser($googleUser)
    {
        $role = session('google_role', 'customer');

        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => null,
            'role' => $role,
            'google_id' => $googleUser->getId(),
        ]);

        Auth::login($user);

        session()->forget(['google_from', 'google_role']);

        return $this->redirectBasedOnRole($user);
    }
}