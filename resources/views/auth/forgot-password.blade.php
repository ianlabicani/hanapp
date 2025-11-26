@extends('shell')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-md bg-white p-6 rounded shadow">
            <a href="{{ url('/') }}" class="mb-4 flex items-center gap-3 no-underline hover:opacity-95">
                <div class="flex items-center justify-center w-12 h-12 rounded bg-gradient-to-br from-orange-400 to-red-500 text-white">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800">HanApp</div>
                    <div class="text-xs text-gray-500">Discover local foodspots</div>
                </div>
            </a>
            <h1 class="text-2xl font-semibold mb-4">Forgot Password</h1>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
