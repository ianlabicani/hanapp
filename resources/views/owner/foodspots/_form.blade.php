@csrf

{{-- hidden input to track selected thumbnail (index in the images array) --}}
<input type="hidden" name="thumbnail_index" id="thumbnail_index" value="{{ old('thumbnail_index', isset($foodspot) && $foodspot->thumbnail ? array_search($foodspot->thumbnail, $foodspot->images ?? []) : '') }}">

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-utensils"></i></span>
            <input type="text" name="name" value="{{ old('name', $foodspot->name ?? '') }}" class="pl-10 block w-full border-gray-300 rounded" required>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-location-dot"></i></span>
            <input type="text" name="address" value="{{ old('address', $foodspot->address ?? '') }}" class="pl-10 block w-full border-gray-300 rounded">
        </div>
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
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-quote-right"></i></span>
            <input type="text" name="tagline" value="{{ old('tagline', $foodspot->tagline ?? '') }}" class="pl-10 block w-full border-gray-300 rounded">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-phone"></i></span>
            <input type="text" name="contact_number" value="{{ old('contact_number', $foodspot->contact_number ?? '') }}" class="pl-10 block w-full border-gray-300 rounded">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" name="email" value="{{ old('email', $foodspot->email ?? '') }}" class="pl-10 block w-full border-gray-300 rounded">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Latitude</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-location-crosshairs"></i></span>
            <input type="text" name="latitude" value="{{ old('latitude', $foodspot->latitude ?? '') }}" class="pl-10 block w-full border-gray-300 rounded bg-gray-50" readonly>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Longitude</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-2 text-gray-400"><i class="fa-solid fa-location-crosshairs"></i></span>
            <input type="text" name="longitude" value="{{ old('longitude', $foodspot->longitude ?? '') }}" class="pl-10 block w-full border-gray-300 rounded bg-gray-50" readonly>
        </div>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Location (click or drag pin)</label>
        <div id="foodspot-map" class="mt-1 w-full border-gray-300 rounded" style="height:320px;"></div>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <div class="mt-1 relative">
            <span class="absolute left-3 top-3 text-gray-400"><i class="fa-solid fa-file-lines"></i></span>
            <textarea name="description" class="pl-10 mt-1 block w-full border-gray-300 rounded">{{ old('description', $foodspot->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Images</label>
        <div class="mt-1">
            <input id="images-input" type="file" name="images[]" multiple accept="image/*" class="block w-full">
            <p class="text-xs text-gray-500 mt-1">You can upload multiple images. Select one as the thumbnail.</p>

            {{-- existing images (when editing) --}}
            @if(isset($foodspot) && !empty($foodspot->images))
                <div id="existing-images" class="grid grid-cols-3 gap-2 mt-2">
                    @foreach($foodspot->images as $i => $img)
                        <div class="relative border rounded overflow-hidden">
                            <img src="{{ asset('storage/'.$img) }}" class="w-full h-32 object-cover">
                            <label class="absolute top-1 left-1 bg-white bg-opacity-75 rounded px-1 text-xs">
                                <input type="radio" name="thumbnail_radio_existing" value="{{ $i }}" class="thumbnail-radio" data-index="{{ $i }}" {{ isset($foodspot->thumbnail) && $foodspot->thumbnail === $img ? 'checked' : '' }}>
                                Thumbnail
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif

            <div id="image-previews" class="grid grid-cols-3 gap-2 mt-2"></div>
        </div>
    </div>

    <div class="sm:col-span-2 flex items-center justify-end space-x-2">
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

            // Image preview & thumbnail selection logic
            const imagesInput = document.getElementById('images-input');
            const previews = document.getElementById('image-previews');
            const thumbnailIndexInput = document.getElementById('thumbnail_index');
            const existingCount = {{ isset($foodspot) ? count($foodspot->images ?? []) : 0 }};

            function attachThumbnailHandlers() {
                document.querySelectorAll('.thumbnail-radio').forEach(function (el) {
                    el.addEventListener('change', function () {
                        const idx = el.getAttribute('data-index');
                        thumbnailIndexInput.value = idx;
                    });
                });
            }

            // apply handlers to any existing radios on page load
            attachThumbnailHandlers();

            if (imagesInput && previews) {
                imagesInput.addEventListener('change', function (ev) {
                    previews.innerHTML = '';
                    const files = Array.from(ev.target.files || []);
                    files.forEach((file, i) => {
                        if (!file.type.startsWith('image/')) return;
                        const reader = new FileReader();
                        const wrap = document.createElement('div');
                        wrap.className = 'relative border rounded overflow-hidden';

                        const img = document.createElement('img');
                        img.className = 'w-full h-32 object-cover';

                        const radioLabel = document.createElement('label');
                        radioLabel.className = 'absolute top-1 left-1 bg-white bg-opacity-75 rounded px-1 text-xs';

                        const radio = document.createElement('input');
                        // new files will be appended after existing images on submit
                        radio.type = 'radio';
                        radio.name = 'thumbnail_radio_preview';
                        radio.className = 'thumbnail-radio';
                        radio.setAttribute('data-index', existingCount + i);
                        radio.value = existingCount + i;
                        radioLabel.appendChild(radio);
                        radioLabel.appendChild(document.createTextNode(' Thumbnail'));

                        reader.onload = function (e) {
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        wrap.appendChild(img);
                        wrap.appendChild(radioLabel);
                        previews.appendChild(wrap);
                    });

                    // re-attach handlers so clicking newly-created radios updates hidden input
                    attachThumbnailHandlers();
                });
            }
        });
    </script>
@endpush
