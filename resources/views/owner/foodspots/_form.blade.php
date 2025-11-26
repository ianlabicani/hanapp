@csrf

<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-utensils"></i></span>
            <input type="text" name="name" value="{{ old('name', $foodspot->name ?? '') }}" class="pl-10 block w-full border-gray-300 rounded" required>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" name="address" value="{{ old('address', $foodspot->address ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-tag"></i></span>
            <input type="text" name="category" value="{{ old('category', $foodspot->category ?? '') }}" class="pl-10 block w-full border-gray-300 rounded">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Tagline</label>
        <input type="text" name="tagline" value="{{ old('tagline', $foodspot->tagline ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" name="contact_number" value="{{ old('contact_number', $foodspot->contact_number ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $foodspot->email ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Latitude</label>
        <input type="text" name="latitude" value="{{ old('latitude', $foodspot->latitude ?? '') }}" class="mt-1 block w-full border-gray-300 rounded bg-gray-50" readonly>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Longitude</label>
        <input type="text" name="longitude" value="{{ old('longitude', $foodspot->longitude ?? '') }}" class="mt-1 block w-full border-gray-300 rounded bg-gray-50" readonly>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Location (click or drag pin)</label>
        <div id="foodspot-map" class="mt-1 w-full border-gray-300 rounded" style="height:320px;"></div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" class="mt-1 block w-full border-gray-300 rounded">{{ old('description', $foodspot->description ?? '') }}</textarea>
    </div>

    <div class="flex items-center justify-end space-x-2">
        <a href="{{ route('owner.foodspots.index') }}" class="text-sm text-gray-600"><i class="fa-solid fa-arrow-left mr-1"></i>Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded"><i class="fa-solid fa-floppy-disk mr-1"></i>Save</button>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const latInput = document.querySelector('input[name="latitude"]');
            const lngInput = document.querySelector('input[name="longitude"]');
            const mapEl = document.getElementById('foodspot-map');
            if (!mapEl || !latInput || !lngInput || typeof L === 'undefined') return;

            const defaultLat = parseFloat(latInput.value) || 14.5995;
            const defaultLng = parseFloat(lngInput.value) || 120.9842;
            const startZoom = (latInput.value && lngInput.value) ? 14 : 12;

            const map = L.map(mapEl).setView([defaultLat, defaultLng], startZoom);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

            function setInputs(lat, lng) {
                latInput.value = parseFloat(lat).toFixed(6);
                lngInput.value = parseFloat(lng).toFixed(6);
            }

            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                setInputs(pos.lat, pos.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                setInputs(e.latlng.lat, e.latlng.lng);
            });
        });
    </script>
@endpush
