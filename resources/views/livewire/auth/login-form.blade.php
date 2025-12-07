<div>
<!-- Main split layout -->
<div class="split-layout flex min-h-screen">
    <!-- Left section - Brand/Info -->
    <div class="left-section bg-green-800 text-white w-1/2 flex flex-col justify-center items-center p-12 relative overflow-hidden">
        <!-- Floating circles background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-20 w-32 h-32 rounded-full bg-green-700 opacity-10 animate-pulse" style="animation-delay: 0s;"></div>
            <div class="absolute bottom-1/4 right-1/4 w-40 h-40 rounded-full bg-green-600 opacity-10 animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/3 right-20 w-24 h-24 rounded-full bg-green-500 opacity-10 animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <!-- Logo with animation -->
        <div class="logo-animation mb-8 z-10">
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20">
                <div class="bg-white rounded-xl p-6">
                    <h1 class="text-4xl font-bold text-center">
                        <span class="text-green-800">Taji</span> <span class="text-green-600">Yako</span>
                    </h1>
                    <p class="text-sm text-gray-600 text-center mt-1">PROPERTIES & INVESTMENTS</p>
                </div>
            </div>
        </div>
        
        <!-- Brand content -->
        <div class="text-center max-w-md z-10">
            <h2 class="text-3xl font-bold mb-4">Find Your Dream Property</h2>
            <p class="text-lg mb-8 opacity-90">Access your personalized property dashboard and continue your real estate journey with us.</p>
            
            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <div class="bg-green-600 bg-opacity-20 p-2 rounded-full mr-4">
                        <i class="fas fa-home text-green-300 text-xl"></i>
                    </div>
                    <span>Exclusive property listings</span>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-600 bg-opacity-20 p-2 rounded-full mr-4">
                        <i class="fas fa-map-marked-alt text-green-300 text-xl"></i>
                    </div>
                    <span>Prime locations across the country</span>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-600 bg-opacity-20 p-2 rounded-full mr-4">
                        <i class="fas fa-shield-alt text-green-300 text-xl"></i>
                    </div>
                    <span>Secure and verified property transactions</span>
                </div>
            </div>
        </div>
        
        <!-- Moving house animation -->
        <div class="absolute bottom-0 left-0 w-full h-16 overflow-hidden z-0">
            <div class="absolute bottom-0 left-0 flex items-center" style="animation: houseMove 25s linear infinite;">
                <i class="fas fa-home text-green-400 text-4xl mr-8"></i>
                <i class="fas fa-building text-green-300 text-4xl mr-8"></i>
                <i class="fas fa-warehouse text-green-200 text-4xl"></i>
            </div>
        </div>
        
        <style>
            @keyframes houseMove {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100vw); }
            }
        </style>
    </div>
    
    <!-- Right section - Login form -->
    <div class="right-section w-1/2 flex flex-col justify-center items-center p-4 bg-white">
        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-1">Welcome Back</h2>
            <p class="text-gray-600 mb-4">Sign in to access your Taji Yako Properties account</p>
            
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Login form -->
            <form wire:submit.prevent="login" class="space-y-6">
                <div class="animate__animated animate__fadeIn">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            wire:model="email" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300"
                            placeholder="your@email.com"
                            autofocus
                        >
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="animate__animated animate__fadeIn animate__delay-1s">
                    <div class="flex justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover-underline">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            wire:model="password" 
                            required 
                            class="input-focus-effect w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none transition-all duration-300"
                            placeholder="••••••••"
                        >
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center" id="togglePassword">
                            <i class="fas fa-eye text-gray-400"></i>
                        </button>
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="animate__animated animate__fadeIn animate__delay-2s flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           wire:model="remember" 
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>
                
                <div class="animate__animated animate__fadeIn animate__delay-3s">
                    <button 
                        type="submit" 
                        style="background: linear-gradient(to right, #166534, #22c55e);"
                        class="relative overflow-hidden btn-hover-effect btn-active-effect w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-75 cursor-not-allowed"
                        wire:target="login"
                    >
                        <span wire:loading.remove wire:target="login">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </span>
                        <span wire:loading wire:target="login">
                            <i class="fas fa-circle-notch fa-spin mr-2"></i> Signing in...
                        </span>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 animate__animated animate__fadeIn animate__delay-4s">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-500">
                            New to Taji Yako?
                        </span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{route('register')}}" 
                       class="w-full inline-flex justify-center py-2.5 px-4 border border-green-600 rounded-lg shadow-sm text-sm font-medium text-green-700 hover:bg-green-50 transition-colors duration-300 items-center">
                        <i class="fas fa-user-plus text-green-600 mr-2"></i> Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline Scripts (inside the root div) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Add ripple effect to buttons
        document.querySelectorAll('button[type="submit"]').forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple-effect');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });
    });
</script>

<!-- Inline Styles (inside the root div) -->
<style>
    /* Background styles */
    .bg-green-800 {
        background-color: #166534;
    }
    
    /* Animation styles */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.03); }
    }
    
    /* Input focus effect */
    .input-focus-effect:focus {
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
        border-color: #16a34a;
    }
    
    /* Button effects */
    .btn-hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(22, 101, 52, 0.2);
    }
    
    .btn-active-effect:active {
        transform: translateY(0);
    }
    
    /* Ripple effect */
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to { transform: scale(4); opacity: 0; }
    }
    
    /* Link hover effect */
    .hover-underline {
        position: relative;
    }
    
    .hover-underline::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: currentColor;
        transform-origin: bottom right;
        transition: transform 0.25s ease-out;
    }
    
    .hover-underline:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    
    /* Logo animation */
    .logo-animation {
        animation: float 6s ease-in-out infinite;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .split-layout {
            flex-direction: column;
        }
        
        .left-section, .right-section {
            width: 100% !important;
            padding: 2rem !important;
        }
        
        .left-section {
            height: auto !important;
            padding-bottom: 4rem !important;
        }
    }
</style>
</div>