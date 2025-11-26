@extends('shell')

@section('content')
    <div class="w-full bg-white shadow-md p-6">
        @include('owner._partials.nav')
        @yield('owner-content')
    </div>
@endsection
