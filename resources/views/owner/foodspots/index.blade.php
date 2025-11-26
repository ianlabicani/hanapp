@extends('owner.shell')
@section('owner-content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Manage Foodspots</h1>
        <a href="{{ route('owner.foodspots.create') }}" class="inline-block bg-blue-600 text-white px-3 py-2 rounded">New Foodspot</a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-700">{{ session('success') }}</div>
    @endif

    @if($foodspots->count())
        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Category</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Visits</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($foodspots as $spot)
                        <tr>
                            <td class="px-4 py-2">{{ $spot->name }}</td>
                            <td class="px-4 py-2">{{ $spot->category }}</td>
                            <td class="px-4 py-2">{{ $spot->visits ?? 0 }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('owner.foodspots.show', $spot) }}" class="text-sm text-blue-600 mr-2">View</a>
                                <a href="{{ route('owner.foodspots.edit', $spot) }}" class="text-sm text-yellow-600 mr-2">Edit</a>
                                <form action="{{ route('owner.foodspots.destroy', $spot) }}" method="POST" class="inline" onsubmit="return confirm('Delete this foodspot?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $foodspots->links() }}
        </div>
    @else
        <p class="text-gray-600">You have no foodspots yet.</p>
    @endif
@endsection
