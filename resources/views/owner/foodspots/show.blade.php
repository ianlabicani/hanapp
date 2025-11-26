@extends('owner.shell')
@section('owner-content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold"><i class="fa-solid fa-utensils mr-2"></i>{{ $foodspot->name }}</h1>
            <div class="flex items-center space-x-3">
                <a href="{{ route('owner.foodspots.edit', $foodspot) }}" class="inline-flex items-center text-sm text-yellow-600 px-3 py-1 rounded hover:bg-yellow-50"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit</a>
                <button type="button" class="inline-flex items-center text-sm text-red-600 px-3 py-1 rounded hover:bg-red-50 delete-btn" data-action="{{ route('owner.foodspots.destroy', $foodspot) }}"><i class="fa-solid fa-trash mr-2"></i>Delete</button>
                <a href="{{ route('owner.foodspots.index') }}" class="inline-flex items-center text-sm text-gray-600 px-3 py-1 rounded hover:bg-gray-50"><i class="fa-solid fa-arrow-left mr-2"></i>Back</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded shadow p-4">
                {{-- Main image viewer --}}
                <div class="w-full h-96 bg-gray-100 flex items-center justify-center overflow-hidden rounded">
                    @php
                        $main = $foodspot->thumbnail ?? ($foodspot->images[0] ?? null);
                    @endphp
                    @if($main)
                        <img id="main-image" src="{{ asset('storage/' . $main) }}" alt="{{ $foodspot->name }}" class="object-cover w-full h-full">
                    @else
                        <div class="text-gray-400 text-center">
                            <i class="fa-solid fa-image fa-3x"></i>
                            <div class="mt-2">No images</div>
                        </div>
                    @endif
                </div>

                {{-- Thumbnails --}}
                @if(!empty($foodspot->images))
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach($foodspot->images as $img)
                            <button type="button" class="thumb-btn border rounded overflow-hidden focus:outline-none" data-src="{{ asset('storage/' . $img) }}">
                                <img src="{{ asset('storage/' . $img) }}" alt="" class="w-full h-24 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="bg-white rounded shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold">Details</h2>
                        <p class="text-sm text-gray-500">Owner view</p>
                    </div>
                </div>

                <dl class="mt-4 grid grid-cols-1 gap-3 text-sm text-gray-700">
                    <div>
                        <dt class="font-medium">Category</dt>
                        <dd>{{ $foodspot->category ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Tagline</dt>
                        <dd>{{ $foodspot->tagline ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Address</dt>
                        <dd>{{ $foodspot->address ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Contact</dt>
                        <dd>{{ $foodspot->contact_number ?? '—' }} @if($foodspot->email) · <a href="mailto:{{ $foodspot->email }}" class="text-blue-600">{{ $foodspot->email }}</a>@endif</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Visits</dt>
                        <dd>{{ $foodspot->visits ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Coordinates</dt>
                        <dd>
                            @if($foodspot->latitude && $foodspot->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $foodspot->latitude }},{{ $foodspot->longitude }}" target="_blank" class="text-blue-600">{{ $foodspot->latitude }}, {{ $foodspot->longitude }}</a>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    @if($foodspot->latitude && $foodspot->longitude)
                        <div>
                            <dt class="font-medium mb-2">Location</dt>
                            <dd>
                                <div id="foodspot-map" class="w-full h-48 rounded border"></div>
                            </dd>
                        </div>
                    @endif
                </dl>

                @if($foodspot->description)
                    <div class="mt-4">
                        <h3 class="font-medium">About</h3>
                        <p class="text-sm text-gray-700 mt-1">{{ $foodspot->description }}</p>
                    </div>
                @endif
            </aside>
        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.thumb-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const src = btn.getAttribute('data-src');
                    const main = document.getElementById('main-image');
                    if (main && src) main.src = src;
                });
            });

            // Initialize map if coordinates exist
            const mapEl = document.getElementById('foodspot-map');
            if (mapEl && typeof L !== 'undefined') {
                const lat = {{ $foodspot->latitude ?? 0 }};
                const lng = {{ $foodspot->longitude ?? 0 }};

                if (lat && lng) {
                    const map = L.map(mapEl).setView([lat, lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([lat, lng]).addTo(map)
                        .bindPopup('<strong>{{ addslashes($foodspot->name) }}</strong>')
                        .openPopup();
                }
            }
        });
    </script>
@endpush

@include('owner.foodspots._delete-modal')
@endsection
