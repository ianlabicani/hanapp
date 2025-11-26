@extends('admin.shell')
@section('admin-content')
    <h1 class="text-2xl font-bold mb-4"><i class="fa-solid fa-plus mr-2"></i>New Foodspot</h1>

    @if($errors->any())
        <div class="mb-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.foodspots.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        @include('admin.foodspots._form')
    </form>

@endsection
