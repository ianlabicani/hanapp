@extends('shell')

@section('content')
    <div class="bg-white shadow-md p-6 block">
        @include('owner._partials.nav')
        <div class="container mx-auto">
            @yield('owner-content')
        </div>
    </div>
@endsection
