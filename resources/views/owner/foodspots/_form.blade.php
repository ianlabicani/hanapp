@csrf

<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $foodspot->name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" name="address" value="{{ old('address', $foodspot->address ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <input type="text" name="category" value="{{ old('category', $foodspot->category ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
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
        <input type="text" name="latitude" value="{{ old('latitude', $foodspot->latitude ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Longitude</label>
        <input type="text" name="longitude" value="{{ old('longitude', $foodspot->longitude ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" class="mt-1 block w-full border-gray-300 rounded">{{ old('description', $foodspot->description ?? '') }}</textarea>
    </div>

    <div class="flex items-center justify-end space-x-2">
        <a href="{{ route('owner.foodspots.index') }}" class="text-sm text-gray-600">Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Save</button>
    </div>
</div>
