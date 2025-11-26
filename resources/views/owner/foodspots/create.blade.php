@extends('owner.shell')
@section('owner-content')
    <h1 class="text-2xl font-bold mb-4">New Foodspot</h1>

    @if($errors->any())
        <div class="mb-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.foodspots.store') }}" method="POST" class="space-y-4 bg-white p-4 rounded shadow">
        @include('owner.foodspots._form')
    </form>

@endsection
