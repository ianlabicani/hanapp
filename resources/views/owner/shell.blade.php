@extends('shell')

@section('content')
    <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-lg shadow-md p-6">
        @include('owner._partials.nav')
        @yield('owner-content')
    </div>
@endsection
