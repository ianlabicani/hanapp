@extends('admin.shell')
@section('admin-content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold"><i class="fa-solid fa-user mr-2"></i>{{ $user->name }}</h1>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-600 px-3 py-1 rounded hover:bg-gray-50">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- User Details --}}
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-id-card mr-2"></i>User Details</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">ID</dt>
                        <dd class="text-gray-900">{{ $user->id }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Name</dt>
                        <dd class="text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Email</dt>
                        <dd class="text-gray-900">
                            <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:underline">{{ $user->email }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Email Verified</dt>
                        <dd class="text-gray-900">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center text-green-600"><i class="fa-solid fa-check-circle mr-1"></i>{{ $user->email_verified_at->format('M d, Y H:i') }}</span>
                            @else
                                <span class="text-gray-400">Not verified</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Registered</dt>
                        <dd class="text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Last Updated</dt>
                        <dd class="text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Roles --}}
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-shield-halved mr-2"></i>Roles</h2>
                @if($user->roles->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->roles as $role)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                <i class="fa-solid {{ $role->name === 'admin' ? 'fa-user-shield' : 'fa-user-tag' }} mr-2"></i>
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No roles assigned.</p>
                @endif
            </div>

            {{-- Statistics --}}
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-chart-simple mr-2"></i>Statistics</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Total Foodspots</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $user->foodspots->count() }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- User's Foodspots --}}
        @if($user->foodspots->count())
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-utensils mr-2"></i>Foodspots ({{ $user->foodspots->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($user->foodspots as $spot)
                        <div class="border rounded overflow-hidden">
                            <div class="h-32 bg-gray-100">
                                @php
                                    $thumb = $spot->thumbnail ?? ($spot->images[0] ?? null);
                                @endphp
                                @if($thumb)
                                    <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $spot->name }}" class="w-full h-32 object-cover">
                                @else
                                    <div class="w-full h-32 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-sm truncate">{{ $spot->name }}</h3>
                                <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ $spot->category ?? '—' }}</span>
                                    <span><i class="fa-solid fa-eye mr-1"></i>{{ $spot->visits ?? 0 }}</span>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('admin.foodspots.show', $spot) }}" class="text-blue-600 text-xs hover:underline">
                                        <i class="fa-solid fa-eye mr-1"></i>View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
