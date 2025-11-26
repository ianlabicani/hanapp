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
            <h1 class="text-2xl font-semibold mb-4">Verify Your Email</h1>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-primary-button>
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
