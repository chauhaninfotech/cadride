<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="text-center mb-4">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Cadride Logo" class="mx-auto mb-4 mt-4" >
        <h2 class="text-2xl font-bold">Welcome Back!</h2>
        <p class="text-gray-600">Please sign in to your account</p>
    </div>
    <form method="POST" action="{{ route('login') }}" style="padding: 30px 10px;">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

     

        <div class="flex items-center justify-end mt-4">
         

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
