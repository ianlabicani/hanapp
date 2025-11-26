@extends('owner.shell')
@section('owner-content')
    <h1 class="text-2xl font-bold mb-4"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Foodspot</h1>

    @if($errors->any())
        <div class="mb-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.foodspots.update', $foodspot) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        @method('PATCH')
        @include('owner.foodspots._form')
    </form>

    @if(!empty($foodspot->images))
        <div class="mt-4 bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Images</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach($foodspot->images as $i => $img)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $img) }}" alt="" class="w-full h-32 object-cover rounded">
                        <form action="{{ route('owner.foodspots.images.destroy', $foodspot) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="image_index" value="{{ $i }}">
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded text-xs" onclick="return confirm('Remove this image?')">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
