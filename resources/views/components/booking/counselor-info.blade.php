@props(['counselor', 'showViewProfile' => true, 'viewProfileRoute' => null])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-[#171213] flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d]">psychology</span>
            Counselor Information
        </h3>
        @if($showViewProfile && $viewProfileRoute)
        <a href="{{ $viewProfileRoute }}" class="text-[#7b1e2d] text-sm font-medium hover:underline">View Profile</a>
        @endif
    </div>
    <div class="flex flex-col sm:flex-row gap-6">
        <div class="shrink-0">
            @if($counselor->user->profile_pic)
            <div class="size-24 rounded-2xl bg-cover bg-center border border-[#e6e0e0]" style="background-image: url('{{ asset('storage/' . $counselor->user->profile_pic) }}');"></div>
            @else
            <div class="size-24 rounded-2xl bg-[#f8f6f6] border border-[#e6e0e0] flex items-center justify-center">
                <span class="material-symbols-outlined text-[48px] text-[#83676c]">psychology</span>
            </div>
            @endif
        </div>
        <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Counselor Name</p>
                <p class="text-base font-medium text-[#171213]">{{ $counselor->user->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Counselor ID</p>
                <p class="text-base font-medium text-[#171213]">#CN-{{ $counselor->id }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Email</p>
                <p class="text-base font-medium text-[#171213]">{{ $counselor->user->email }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Phone</p>
                <p class="text-base font-medium text-[#171213]">{{ $counselor->user->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Status</p>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($counselor->status === 'active') bg-green-100 text-green-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ ucfirst($counselor->status) }}
                </span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1">Price Per Session</p>
                <p class="text-base font-bold text-[#7b1e2d]">Rp {{ number_format($counselor->price_per_session ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</section>
