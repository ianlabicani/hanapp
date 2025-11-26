@extends('shell')

@section('content')
    <div class="bg-white shadow-md p-6 block">
        @include('admin._partials.nav')
        <div class="container mx-auto">
            @yield('admin-content')
        </div>
    </div>
@endsection
