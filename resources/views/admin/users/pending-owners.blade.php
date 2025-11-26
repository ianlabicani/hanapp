@extends('admin.shell')
@section('admin-content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-user-clock mr-2"></i>Pending Owner Requests</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
            <i class="fa-solid fa-arrow-left mr-1"></i>Back to Users
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->count())
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $user->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.users.approve-owner', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700" onclick="return confirm('Approve owner request for {{ $user->name }}?')">
                                            <i class="fa-solid fa-check mr-1"></i>Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject-owner', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700" onclick="return confirm('Reject owner request for {{ $user->name }}?')">
                                            <i class="fa-solid fa-times mr-1"></i>Reject
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                        <i class="fa-solid fa-eye mr-1"></i>View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @else
        <div class="bg-white rounded shadow p-6 text-center text-gray-500">
            <i class="fa-solid fa-check-circle fa-3x mb-3 text-green-400"></i>
            <p>No pending owner requests.</p>
        </div>
    @endif
@endsection
