@extends('shell')

@section('content')
    <div class="bg-white shadow-md p-6 block">
        @include('user._partials.nav')
        <div class="container mx-auto">
            @yield('user-content')
        </div>
    </div>
@endsection
