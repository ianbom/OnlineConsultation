@props(['client'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Klien</h2>
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            @if($client->profile_pic)
                <img src="{{ asset('storage/' . $client->profile_pic) }}"
                     alt="{{ $client->name }}"
                     class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
            @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <span class="text-white text-xl font-bold">
                        {{ strtoupper(substr($client->name, 0, 1)) }}
                    </span>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-semibold text-gray-900">{{ $client->name }}</h3>
            <div class="mt-3 space-y-2">
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $client->email }}</span>
                </div>
                @if($client->phone)
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $client->phone }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
