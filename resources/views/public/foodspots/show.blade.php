@extends('public.shell')
@section('public-content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded shadow p-4">
                @php $main = $foodspot->thumbnail ?? ($foodspot->images[0] ?? null); @endphp
                <div class="w-full h-96 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                    @if($main)
                        <img src="{{ asset('storage/' . $main) }}" alt="{{ $foodspot->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-gray-400 text-center">
                            <i class="fa-solid fa-image fa-3x"></i>
                            <div class="mt-2">No images</div>
                        </div>
                    @endif
                </div>

                @if(!empty($foodspot->images))
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach($foodspot->images as $img)
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-24 object-cover rounded">
                        @endforeach
                    </div>
                @endif

                <div class="mt-6">
                    <h1 class="text-2xl font-semibold">{{ $foodspot->name }}</h1>
                    @if($foodspot->tagline)
                        <p class="text-gray-600 mt-1">{{ $foodspot->tagline }}</p>
                    @endif
                    <p class="mt-4 text-gray-700">{{ $foodspot->description }}</p>
                </div>
            </div>

            <aside class="bg-white rounded shadow p-4">
                <dl class="text-sm text-gray-700">
                    <div class="mb-3">
                        <dt class="font-medium">Category</dt>
                        <dd>{{ $foodspot->category ?? '—' }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Address</dt>
                        <dd>{{ $foodspot->address ?? '—' }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Contact</dt>
                        <dd>{{ $foodspot->contact_number ?? '—' }} @if($foodspot->email) · <a href="mailto:{{ $foodspot->email }}" class="text-blue-600">{{ $foodspot->email }}</a>@endif</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Opening Hours</dt>
                        <dd>{{ $foodspot->open_time ?? '—' }} @if($foodspot->close_time) - {{ $foodspot->close_time }}@endif</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Coordinates</dt>
                        <dd>
                            @if($foodspot->latitude && $foodspot->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $foodspot->latitude }},{{ $foodspot->longitude }}" target="_blank" class="text-blue-600">View on Google Maps</a>
                            @else
                                —
                            @endif
                        </dd>
                    </div>

                    @if($foodspot->latitude && $foodspot->longitude)
                        <div class="mb-3">
                            <dt class="font-medium mb-2">Location</dt>
                            <dd>
                                <div id="foodspot-map" class="w-full h-48 rounded border"></div>
                            </dd>
                        </div>

                        <div>
                            <dt class="font-medium mb-2">Get Directions</dt>
                            <dd>
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $foodspot->latitude }},{{ $foodspot->longitude }}" target="_blank" class="flex items-center text-sm text-white bg-blue-600 px-3 py-2 rounded hover:bg-blue-700">
                                    <i class="fa-solid fa-diamond-turn-right mr-2"></i>
                                    Directions via Google Maps
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </aside>
        </div>
    </div>

@if($foodspot->latitude && $foodspot->longitude)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('foodspot-map');
    if (!mapEl || typeof L === 'undefined') return;

    const lat = {{ $foodspot->latitude }};
    const lng = {{ $foodspot->longitude }};

    const map = L.map(mapEl).setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup('<strong>{{ addslashes($foodspot->name) }}</strong>')
        .openPopup();
});
</script>
@endpush
@endif
@endsection
