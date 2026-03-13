<x-admin.app>
    <script defer src="/assets/js/apexcharts.js"></script>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Counselor</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Detail</span>
            </li>
        </ul>

        <div class="pt-5">
            <!-- Counselor Profile Section -->
            <div class="mb-6">
                <div class="panel">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <!-- Profile Picture -->
                        <div class="shrink-0">
                            @if($counselor->user->profile_pic)
                                <img class="w-24 h-24 rounded-full object-cover border-4 border-primary/20"
                                    src="{{ asset('storage/' . $counselor->user->profile_pic) }}" alt="profile" />
                            @else
                                <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center border-4 border-primary/20">
                                    <span class="text-3xl font-semibold text-primary">{{ substr($counselor->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold dark:text-white-light mb-2">{{ $counselor->user->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $counselor->specialization }}</p>

                            <!-- Status Badge -->
                            <div class="flex items-center gap-3 flex-wrap">
                                @if($counselor->status === 'active')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Active</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger">Inactive</span>
                                @endif

                                <div class="text-sm dark:text-white-light">
                                    <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                    <a href="mailto:{{ $counselor->user->email }}" class="text-primary hover:underline ml-1">{{ $counselor->user->email }}</a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex flex-col gap-2">
                            {{-- Primary Action --}}
                            <a href="{{ route('admin.counselor.edit', $counselor->id) }}"
                               class="btn btn-primary hover:bg-primary-dark transition-colors duration-200">
                                Edit Profile
                            </a>

                            {{-- Tertiary / Back Action --}}
                            <a href="{{ route('admin.counselor.index') }}"
                               class="btn border border-gray-300 text-gray-700
                                      hover:bg-gray-100 hover:text-gray-900
                                      transition-colors duration-200">
                                Back to List
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Statistics Component - Same as Dashboard -->
        <x-main-statistics
            :showClient="false"
            :totalClients="$totalClients"
            :filteredRevenue="$filteredRevenue"
            :filteredBookings="$filteredBookings"
            :filterType="$filterType"
            :filterMonth="$filterMonth"
            :filterYear="$filterYear"
        />

        <!-- Charts Component - Same as Dashboard -->
        <x-statistics-chart
            :chartIncome="$chartIncome"
            :chartBookings="$chartBookings"
        />

        <!-- Recent Bookings Component - Same as Dashboard -->
        <x-recent-bookings
            :bookings="$recentBookings"
        />

        {{-- RATINGS SECTION --}}
        <div class="mt-6 panel">
            <div class="flex flex-wrap items-center justify-between mb-5 gap-3">
                <div>
                    <h5 class="text-lg font-semibold dark:text-white-light">Rating & Ulasan</h5>
                    @if($ratings->total() > 0)
                        @php
                            $avgRating = \App\Models\RatingCounselor::where('counselor_id', $counselor->user->id)->avg('rating');
                        @endphp
                        <div class="flex items-center gap-2 mt-1">
                            <div class="flex items-center gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-xs text-gray-400">({{ $ratings->total() }} ulasan)</span>
                        </div>
                    @endif
                </div>

                {{-- Sort Controls --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">Urutkan:</span>
                    <a href="{{ route('admin.counselor.show', array_merge([$counselor->id], request()->except(['sort_by', 'sort_dir', 'ratings_page']), ['sort_by' => 'created_at', 'sort_dir' => ($ratingsSortBy === 'created_at' && $ratingsSortDir === 'desc') ? 'asc' : 'desc'])) }}"
                        class="btn btn-sm {{ $ratingsSortBy === 'created_at' ? 'btn-primary' : 'btn-outline-dark' }}">
                        Terbaru
                        @if($ratingsSortBy === 'created_at')
                            <svg class="w-3 h-3 ml-1 inline {{ $ratingsSortDir === 'asc' ? '' : 'rotate-180' }}" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-6 8h12z"/></svg>
                        @endif
                    </a>
                    <a href="{{ route('admin.counselor.show', array_merge([$counselor->id], request()->except(['sort_by', 'sort_dir', 'ratings_page']), ['sort_by' => 'rating', 'sort_dir' => ($ratingsSortBy === 'rating' && $ratingsSortDir === 'desc') ? 'asc' : 'desc'])) }}"
                        class="btn btn-sm {{ $ratingsSortBy === 'rating' ? 'btn-primary' : 'btn-outline-dark' }}">
                        Rating
                        @if($ratingsSortBy === 'rating')
                            <svg class="w-3 h-3 ml-1 inline {{ $ratingsSortDir === 'asc' ? '' : 'rotate-180' }}" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-6 8h12z"/></svg>
                        @endif
                    </a>
                </div>
            </div>

            @if($ratings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($ratings as $rating)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                        <span class="text-sm font-semibold text-primary">
                                            {{ substr($rating->booking->client->name ?? 'U', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm dark:text-white-light">
                                            {{ $rating->booking->client->name ?? 'Unknown' }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            Booking #{{ $rating->booking_id }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                            @if($rating->commentar)
                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-3">
                                    "{{ $rating->commentar }}"
                                </p>
                            @endif

                            <p class="text-xs text-gray-400">
                                {{ $rating->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mt-5">
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ratings->firstItem() }} - {{ $ratings->lastItem() }} dari {{ $ratings->total() }} ulasan
                    </div>
                    <div>
                        {{ $ratings->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                    <p class="text-sm text-gray-400">Belum ada rating untuk konselor ini.</p>
                </div>
            @endif
        </div>
    </div>


</x-admin.app>
