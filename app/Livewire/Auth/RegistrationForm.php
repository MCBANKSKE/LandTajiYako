<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAccount;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Session;

class RegistrationForm extends Component
{
    // User fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    // Customer fields
    public $phone = '';
    public $address = '';
    public $nationality_id = '';
    public $preffered_currency_id = '';
    public $tax_number = '';
    
    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:20'],
        'address' => ['required', 'string', 'max:255'],
        'nationality_id' => ['required', 'exists:countries,id'],
        'preffered_currency_id' => ['required', 'exists:countries,id'],
        'tax_number' => ['nullable', 'string', 'max:50'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public function register()
    {
        $validated = $this->validate();

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null, // Ensure email is not verified initially
        ]);

        // Create customer
        $customer = new Customer([
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'nationality_id' => $validated['nationality_id'],
            'preffered_currency_id' => $validated['preffered_currency_id'],
            'tax_number' => $validated['tax_number'] ?? null,
        ]);

        // Create customer account
        $customerAccount = new CustomerAccount([
            'customer_id' => $customer->id,
            'total_credit' => 0.00,
            'total_debit' => 0.00,
            'balance' => 0.00,
        ]);

        $user->customer()->save($customer);
        
        // Assign customer role
        $user->assignRole('customer');

        // Log the user in
        Auth::login($user);
        
        // Trigger the Registered event which will send the verification email
        event(new Registered($user));

        // Show success message
        Session::flash('status', 'A verification link has been sent to your email address. Please verify your email to continue.');

        // Redirect to email verification notice
        return redirect()->route('verification.notice');
    }

    public function updatedNationalityId($value)
    {
        if ($value) {
            $country = Country::find($value);
            if ($country && $country->currency) {
                $this->preffered_currency_id = $value;
            }
        } else {
            $this->preffered_currency_id = '';
        }
    }

    public function updateCurrencyOptions($countryId)
    {
        $country = Country::find($countryId);
        if ($country && $country->currency) {
            $this->preffered_currency_id = $country->id;
            return true;
        }
        return false;
    }

    public function render()
    {
        $countries = Country::all();
        $currencies = Country::whereNotNull('currency')
            ->select('id', 'currency as code', 'currency_symbol as symbol')
            ->distinct()
            ->get();
            
        $default_currency_id = $this->nationality_id;
            
        return view('livewire.auth.registration-form', compact('countries', 'currencies', 'default_currency_id'));
    }
}