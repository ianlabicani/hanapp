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
            <h1 class="text-2xl font-semibold mb-4">Register</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Account Type -->
                <div class="mt-4">
                    <x-input-label for="account_type" :value="__('Account Type')" />
                    <select id="account_type" name="account_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="user" {{ old('account_type') === 'user' ? 'selected' : '' }}>User - Browse and discover foodspots</option>
                        <option value="owner" {{ old('account_type') === 'owner' ? 'selected' : '' }}>Owner - Manage your own foodspots (requires approval)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Owner accounts require admin approval before you can create foodspots.</p>
                    <x-input-error :messages="$errors->get('account_type')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
