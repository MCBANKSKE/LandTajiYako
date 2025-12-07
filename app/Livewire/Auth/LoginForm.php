<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginForm extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            $user = Auth::user();
            
            return redirect()->intended($this->getDashboardRoute($user));
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    protected function getDashboardRoute($user)
    {
        if ($user->hasRole('admin')) {
            return '/admin';
        }

        if ($user->hasRole('customer')) {
            // ✅ Check if email is verified
            if (is_null($user->email_verified_at)) {
                return route('verification.notice');
            }
            return '/customer';
        }

        return '/';
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
