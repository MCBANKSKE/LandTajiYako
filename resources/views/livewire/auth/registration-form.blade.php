<div>
    <!-- Main split layout -->
<div class="split-layout flex min-h-screen">
    <!-- Left section - Brand/Info -->
    <div class="left-section bg-half-green text-white w-1/2 flex flex-col justify-center items-center p-12 relative overflow-hidden">
        <!-- Floating circles background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-20 w-32 h-32 rounded-full bg-green-700 opacity-10 animate-pulse" style="animation-delay: 0s;"></div>
            <div class="absolute bottom-1/4 right-1/4 w-40 h-40 rounded-full bg-green-700 opacity-10 animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/3 right-20 w-24 h-24 rounded-full bg-green-700 opacity-10 animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <!-- Logo with animation -->
        <div class="logo-animation mb-8 z-10">
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-full p-6 shadow-xl border border-white border-opacity-20">
                <div class="bg-white rounded-full p-6">
                    <h1 class="text-4xl font-bold text-center">
                        <span class="text-green-600">WA</span><span class="text-orange-500">KAH</span>
                    </h1>
                    <p class="text-sm text-gray-600 text-center mt-1">LOGISTICS SOLUTIONS</p>
                </div>
            </div>
        </div>
        
        <!-- Brand content -->
        <div class="text-center max-w-md z-10">
            <h2 class="text-3xl font-bold mb-4">Join Our Network</h2>
            <p class="text-lg mb-8 opacity-90">Become part of WAKAH Logistics and enjoy seamless shipping and logistics solutions.</p>
            
            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <div class="bg-green-500 bg-opacity-20 p-2 rounded-full mr-4">
                        <i class="fas fa-shipping-fast text-green-300 text-xl"></i>
                    </div>
                    <span>Real-time shipment tracking</span>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-500 bg-opacity-20 p-2 rounded-full mr-4">
                        <i class="fas fa-hand-holding-usd text-green-300 text-xl"></i>
                    </div>
                    <span>Competitive pricing</span>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-500 bg-opacity-20 p-2 rounded-full mr-4">
                        <i class="fas fa-headset text-green-300 text-xl"></i>
                    </div>
                    <span>24/7 Customer support</span>
                </div>
            </div>
        </div>
        
        <!-- Moving truck animation -->
        <div class="absolute bottom-0 left-0 w-full h-16 overflow-hidden z-0">
            <div class="absolute bottom-0 left-0 flex items-center" style="animation: truckMove 20s linear infinite;">
                <i class="fas fa-truck text-orange-400 text-4xl mr-2"></i>
                <i class="fas fa-truck text-orange-300 text-4xl mr-2"></i>
                <i class="fas fa-truck text-orange-200 text-4xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Right section - Registration form -->
    <div class="right-section w-1/2 flex flex-col justify-center items-center p-4 bg-white">
        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-1">Create Account</h2>
            <p class="text-gray-600 mb-4">Join WAKAH Logistics and manage your shipments efficiently</p>
            
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Registration form -->
            <form wire:submit.prevent="register" class="space-y-4">
                <!-- Name -->
                <div class="animate__animated animate__fadeIn">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name
                    </label>
                    <div class="relative">
                        <input 
                            id="name" 
                            type="text" 
                            wire:model="name" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="Mark Clinton"
                            autofocus
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        @error('name')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Email -->
                <div class="animate__animated animate__fadeIn">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="email" 
                            wire:model="email" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="mcbankske@gmail.com"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        @error('email')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Phone -->
                <div class="animate__animated animate__fadeIn">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone Number
                    </label>
                    <div class="relative">
                        <input 
                            id="phone" 
                            type="tel" 
                            wire:model="phone" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="+1234567890"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        @error('phone')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Address -->
                <div class="animate__animated animate__fadeIn">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                        Address
                    </label>
                    <div class="relative">
                        <input 
                            id="address" 
                            type="text" 
                            wire:model="address" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="Your full address"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        @error('address')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Nationality -->
                <div class="animate__animated animate__fadeIn">
                    <label for="nationality_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Nationality
                    </label>
                    <div class="relative">
                    <select 
                        id="nationality_id" 
                        wire:model="nationality_id" 
                        required 
                        class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                    >
                        <option value="">Select your country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-flag text-gray-400"></i>
                        </div>
                        @error('nationality_id')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Preferred Currency -->
                <div class="animate__animated animate__fadeIn">
                    <label for="preffered_currency_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Preferred Currency
                    </label>
                    <div class="relative">
                    <select 
                        id="preffered_currency_id" 
                        wire:model="preffered_currency_id" 
                        @if(!$nationality_id) disabled @endif
                        required 
                        class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12 @if(!$nationality_id) bg-gray-100 @endif"
                    >
                        <option value="">@if($nationality_id) Select preferred currency @else Select nationality first @endif</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" @if($currency->id == $default_currency_id) selected @endif>
                                {{ $currency->code }} ({{ $currency->symbol }})
                            </option>
                        @endforeach
                    </select>
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-money-bill-wave text-gray-400"></i>
                        </div>
                        @error('preffered_currency_id')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Tax Number -->
                <div class="animate__animated animate__fadeIn">
                    <label for="tax_number" class="block text-sm font-medium text-gray-700 mb-1">
                        Tax Number (Optional)
                    </label>
                    <div class="relative">
                        <input 
                            id="tax_number" 
                            type="text" 
                            wire:model="tax_number" 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="VAT/GST number (if applicable)"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-file-invoice-dollar text-gray-400"></i>
                        </div>
                        @error('tax_number')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Password -->
                <div class="animate__animated animate__fadeIn">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            wire:model="password" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="••••••••"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword('password')">
                            <i class="fas fa-eye text-gray-400"></i>
                        </button>
                        @error('password')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Confirm Password -->
                <div class="animate__animated animate__fadeIn">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            wire:model="password_confirmation" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300 pl-12"
                            placeholder="••••••••"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye text-gray-400"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="animate__animated animate__fadeIn">
                    <button 
                        type="submit" 
                        style="background: linear-gradient(to right, #f97316, #fb923c);"
                        class="relative overflow-hidden btn-hover-effect btn-active-effect w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-75 cursor-not-allowed"
                        wire:target="register"
                    >
                        <span wire:loading.remove wire:target="register">
                            <i class="fas fa-user-plus mr-2"></i> Create Account
                        </span>
                        <span wire:loading wire:target="register">
                            <i class="fas fa-circle-notch fa-spin mr-2"></i> Creating your account...
                        </span>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center animate__animated animate__fadeIn">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-orange-500 hover-underline">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    // Function to toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Initialize Select2 when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Get the Livewire component ID
        const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
        const component = window.Livewire.find(componentId);
        
        // Initialize Select2 for nationality
        const $nationalitySelect = $('#nationality_id');
        const $currencySelect = $('#preffered_currency_id');

        // Initialize nationality select
        $nationalitySelect.select2({
            placeholder: 'Select your country',
            allowClear: true
        }).on('change', function() {
            const value = $(this).val();
            
            // Update Livewire property
            component.set('nationality_id', value, true);
            
            // Enable/disable currency select based on selection
            if (value) {
                $currencySelect.prop('disabled', false).removeClass('bg-gray-100');
                // Update currency options based on selected country
                component.call('updateCurrencyOptions', value);
            } else {
                $currencySelect.prop('disabled', true).addClass('bg-gray-100');
                $currencySelect.val('').trigger('change');
            }
        });

        // Initialize currency select
        $currencySelect.select2({
            placeholder: 'Select preferred currency',
            allowClear: true
        }).on('change', function() {
            component.set('preffered_currency_id', $(this).val(), true);
        });

        // Set initial state
        if (!$nationalitySelect.val()) {
            $currencySelect.prop('disabled', true).addClass('bg-gray-100');
        }
    });
</script>
@endpush
<style>
    /* Background styles */
    .bg-half-green {
            background: linear-gradient(135deg, #166534 0%, #14532d 100%);
        }
        
        /* Input focus effect */
        .input-focus-effect:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }
        
        /* Button hover effect */
        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(249, 115, 22, 0.3);
        }
        
        .btn-active-effect:active {
            transform: translateY(0);
        }
        
        /* Animation for the moving truck */
        @keyframes truckMove {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100vw); }
        }
        
        /* Custom scrollbar for select elements */
        select::-ms-expand {
            display: none;
        }
        
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='%239ca3af' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            background-repeat: no-repeat;
            background-position: right 0.7em top 50%;
            background-size: 1.2em auto;
        }
        
        /* Animation classes */
        .animate__animated {
            animation-duration: 0.5s;
        }
        
        .hover-underline {
            position: relative;
            display: inline-block;
        }
        
        .hover-underline:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #f97316;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }
        
        .hover-underline:hover:after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Style for Select2 dropdowns */
        .select2-container .select2-selection {
            min-height: 48px;
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db !important;
            transition: all 0.3s;
            border-radius: 0.5rem;
        }

        .select2-container .select2-selection:focus {
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2) !important;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        .select2-container .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            margin-top: 0.25rem;
        }

        .select2-container .select2-results__option {
            padding: 0.5rem 1rem;
        }

        .select2-container .select2-results__option--highlighted {
            background-color: #ffedd5;
            color: #9a3412;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
        }
        
        /* Fix for Select2 in Livewire */
        .select2-container {
            width: 100% !important;
            z-index: 9999;
        }

</style>
</div>
