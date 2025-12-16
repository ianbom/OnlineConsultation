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
    </div>

    
</x-admin.app>
