@extends('shell')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-lg bg-white p-8 rounded shadow text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fa-solid fa-clock fa-2x"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">Owner Request Pending</h1>

            <p class="text-gray-600 mb-6">
                Your request to become an owner is currently under review. An administrator will review your application and approve it soon.
            </p>

            <div class="bg-gray-50 rounded p-4 mb-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-2">What happens next?</h2>
                <ul class="text-sm text-gray-600 text-left space-y-2">
                    <li class="flex items-start">
                        <i class="fa-solid fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                        <span>An admin will review your request</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                        <span>Once approved, you'll be able to create and manage your foodspots</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                        <span>You'll be notified when your account is approved</span>
                    </li>
                </ul>
            </div>

            <div class="flex items-center justify-center space-x-4">
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    <i class="fa-solid fa-home mr-2"></i>
                    Go to Home
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>

            <p class="mt-6 text-xs text-gray-400">
                Logged in as <span class="font-medium">{{ Auth::user()->email }}</span>
            </p>
        </div>
    </div>
@endsection
