@extends('shell')

@section('content')
    <div class="bg-white shadow-md p-6 block">
        @include('public._partials.nav')
        <div class="container mx-auto">
            @yield('public-content')
        </div>
    </div>
@endsection
