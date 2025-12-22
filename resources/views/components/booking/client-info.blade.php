@props(['client', 'showViewProfile' => true, 'viewProfileRoute' => null])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-[#171213] flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d]">person</span>
            Client Information
        </h3>
        @if($showViewProfile && $viewProfileRoute)
        <a href="{{ $viewProfileRoute }}" class="text-[#7b1e2d] text-sm font-medium hover:underline">View Profile</a>
        @endif
    </div>
    <div class="flex flex-col sm:flex-row gap-6">
        <div class="shrink-0">
            @if($client->profile_pic)
            <div class="size-24 rounded-2xl bg-cover bg-center border border-[#e6e0e0]" style="background-image: url('{{ asset('storage/' . $client->profile_pic) }}');"></div>
            @else
            <div class="size-24 rounded-2xl bg-[#f8f6f6] border border-[#e6e0e0] flex items-center justify-center">
                <span class="material-symbols-outlined text-[48px] text-[#83676c]">person</span>
            </div>
            @endif
        </div>
        <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Full Name</p>
                <p class="text-base font-medium text-[#171213]">{{ $client->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Client ID</p>
                <p class="text-base font-medium text-[#171213]">#CL-{{ $client->id }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Email Address</p>
                <p class="text-base font-medium text-[#171213] flex items-center gap-2">
                    {{ $client->email }}
                    <span class="material-symbols-outlined text-[16px] text-[#83676c] cursor-pointer hover:text-[#7b1e2d]" onclick="copyToClipboard('{{ $client->email }}')">content_copy</span>
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Phone Number</p>
                <p class="text-base font-medium text-[#171213] flex items-center gap-2">
                    {{ $client->phone ?? '-' }}
                    @if($client->phone)
                    <span class="material-symbols-outlined text-[16px] text-green-600">chat</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Role</p>
                <p class="text-base font-medium text-[#171213]">{{ ucfirst($client->role) }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Email Verified</p>
                <p class="text-base font-medium text-[#171213]">
                    @if($client->email_verified_at)
                    <span class="inline-flex items-center gap-1 text-green-600">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        Verified
                    </span>
                    @else
                    <span class="text-[#83676c]">Not Verified</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
