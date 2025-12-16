@props(['counselor'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">
        Informasi Konselor
    </h2>

    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            @if($counselor->user->profile_pic)
                <img
                    src="{{ asset('storage/' . $counselor->user->profile_pic) }}"
                    alt="{{ $counselor->user->name }}"
                    class="w-16 h-16 rounded-full object-cover border"
                >
            @else
                <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center">
                    <span class="text-white text-xl font-bold">
                        {{ strtoupper(substr($counselor->user->name, 0, 1)) }}
                    </span>
                </div>
            @endif
        </div>

        <div class="flex-1">
            <h3 class="text-xl font-semibold text-gray-900">
                {{ $counselor->user->name }}
            </h3>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $counselor->user->email }}</span>
                </div>

                @if($counselor->user->phone)
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $counselor->user->phone }}</span>
                </div>
                @endif

                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $counselor->specialization }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
