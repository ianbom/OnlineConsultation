<x-admin.app>
    <script defer src="/assets/js/apexcharts.js"></script>
    <div x-data="sales">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Sales</span>
            </li>
        </ul>

        <div class="pt-5">
            <!-- Stats Cards Row 1: Bookings -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Booking Statistics</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Today Bookings -->
                    <div class="panel h-full">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="font-semibold text-lg dark:text-white-light">Booking Hari Ini</h5>
                        </div>
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $todayBookings }}</p>
                                <h5 class="text-xs text-white-dark">Bookings</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Bookings -->
                    <div class="panel h-full">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="font-semibold text-lg dark:text-white-light">Minggu Ini</h5>
                        </div>
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-success" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $weeklyBookings }}</p>
                                <h5 class="text-xs text-white-dark">Bookings</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Bookings -->
                    <div class="panel h-full">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="font-semibold text-lg dark:text-white-light">Bulan Ini</h5>
                        </div>
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-warning/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-warning" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 2V5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 2V5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $monthlyBookings }}</p>
                                <h5 class="text-xs text-white-dark">Bookings</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Total Bookings -->
                    <div class="panel h-full">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="font-semibold text-lg dark:text-white-light">Total Bookings</h5>
                        </div>
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-info/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-info" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M22 4L12 14.01L9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $totalBookings }}</p>
                                <h5 class="text-xs text-white-dark">All Time</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 2: Booking Status -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Booking Status</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Completed -->
                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-success" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M22 4L12 14.01L9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $completedBookings }}</p>
                                <h5 class="text-xs text-white-dark">Completed</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Paid -->
                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-blue-300 flex items-center justify-center">
                                    <!-- CHECK / PAID ICON -->
                                    <svg
                                        class="w-6 h-6 text-blue-500"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        />
                                        <path
                                            d="M8 12l3 3 5-6"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">
                                    {{ $paidBookings }}
                                </p>
                                <h5 class="text-xs text-white-dark">
                                    Dibayar
                                </h5>
                            </div>
                        </div>
                    </div>



                    <!-- Cancelled -->
                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-danger/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-danger" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                        <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $cancelledBookings }}</p>
                                <h5 class="text-xs text-white-dark">Cancelled</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Rescheduled -->
                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-warning/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-warning" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 8V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <path d="M3.05 11H5C6.1 11 7 11.9 7 13C7 14.1 6.1 15 5 15H3.05M21.95 11H19C17.9 11 17 11.9 17 13C17 14.1 17.9 15 19 15H21.95M12 3C16.97 3 21 7.03 21 12C21 16.97 16.97 21 12 21C7.03 21 3 16.97 3 12C3 7.03 7.03 3 12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $rescheduledBookings }}</p>
                                <h5 class="text-xs text-white-dark">Rescheduled</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 3: Counselors & Schedules -->
            <div class="mb-6">
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <!-- Counselors Section -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Counselor Statistics</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="panel h-full">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                        <p class="text-xl dark:text-white-light">{{ $totalCounselors }}</p>
                                        <h5 class="text-xs text-white-dark">Total</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="panel h-full">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-success" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                                <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                        <p class="text-xl dark:text-white-light">{{ $activeCounselors }}</p>
                                        <h5 class="text-xs text-white-dark">Active</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="panel h-full">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-warning/70 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-secondary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                                <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                        <p class="text-xl dark:text-white-light">{{ $inactiveCounselors }}</p>
                                        <h5 class="text-xs text-white-dark">Inactive</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedules Section -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Schedule Statistics</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="panel h-full">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-info/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-info" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                                                <path d="M16 2V6M8 2V6M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                        <p class="text-xl dark:text-white-light">{{ $totalSchedules }}</p>
                                        <h5 class="text-xs text-white-dark">Total</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="panel h-full">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-success" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                                <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                        <p class="text-xl dark:text-white-light">{{ $availableSchedules }}</p>
                                        <h5 class="text-xs text-white-dark">Available</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="panel h-full">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-danger/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-danger" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                                <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                        <p class="text-xl dark:text-white-light">{{ $unavailableSchedules }}</p>
                                        <h5 class="text-xs text-white-dark">Unavailable</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 4: Payments -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Payment Statistics</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-success" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2V22M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                                <h5 class="text-xs text-white-dark">Total Income</h5>
                            </div>
                        </div>
                    </div>

                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-danger/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-danger" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 8L8 16M8 8L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">Rp {{ number_format($totalRefund, 0, ',', '.') }}</p>
                                <h5 class="text-xs text-white-dark">Total Refund</h5>
                            </div>
                        </div>
                    </div>

                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-warning/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-warning" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                        <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $pendingPayments }}</p>
                                <h5 class="text-xs text-white-dark">Pending</h5>
                            </div>
                        </div>
                    </div>

                    <div class="panel h-full">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-full bg-danger/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-danger" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.29 3.86L1.82 18C1.64537 18.3024 1.55296 18.6453 1.55199 18.9945C1.55101 19.3437 1.64151 19.6871 1.81445 19.9905C1.98738 20.2939 2.23675 20.5467 2.53773 20.7239C2.83871 20.9011 3.18082 20.9962 3.53 21H20.47C20.8192 20.9962 21.1613 20.9011 21.4623 20.7239C21.7633 20.5467 22.0126 20.2939 22.1856 19.9905C22.3585 19.6871 22.449 19.3437 22.448 18.9945C22.447 18.6453 22.3546 18.3024 22.18 18L13.71 3.86C13.5317 3.52219 13.2629 3.24694 12.9251 3.07728C12.5874 2.90762 12.1974 2.86147 11.8251 2.9412C11.4529 3.02093 11.1212 3.22272 10.8918 3.51553C10.6624 3.80835 10.5466 4.17374 10.56 4.55L10.81 11H2.5C2.22386 11 1.95861 11.1054 1.76878 11.2952C1.57896 11.485 1.47353 11.7503 1.47353 12.0264C1.47353 12.3026 1.57896 12.5679 1.76878 12.7577C1.95861 12.9475 2.22386 13.053 2.5 13.053H10.81L10.56 19.45C10.5466 19.8263 10.6624 20.1917 10.8918 20.4845C11.1212 20.7773 11.4529 20.9791 11.8251 21.0588C12.1974 21.1385 12.5874 21.0924 12.9251 20.9227C13.2629 20.7531 13.5317 20.4778 13.71 20.14L22.18 6C22.3546 5.69759 22.447 5.35468 22.448 5.00549C22.449 4.6563 22.3585 4.31288 22.1856 4.00951C22.0126 3.70613 21.7633 3.45334 21.4623 3.27609C21.1613 3.09884 20.8192 3.0038 20.47 3H3.53C3.18082 3.0038 2.83871 3.09884 2.53773 3.27609C2.23675 3.45334 1.98738 3.70613 1.81445 4.00951C1.64151 4.31288 1.55101 4.6563 1.55199 5.00549C1.55296 5.35468 1.64537 5.69759 1.82 6L10.29 20.14C10.4684 20.4778 10.7372 20.7531 11.0749 20.9227C11.4126 21.0924 11.8026 21.1385 12.1749 21.0588C12.5472 20.9791 12.8789 20.7773 13.1082 20.4845C13.3376 20.1917 13.4534 19.8263 13.44 19.45L13.19 13.053H21.5C21.7761 13.053 22.0414 12.9475 22.2312 12.7577C22.421 12.5679 22.5265 12.3026 22.5265 12.0264C22.5265 11.7503 22.421 11.485 22.2312 11.2952C22.0414 11.1054 21.7761 11 21.5 11H13.19L13.44 4.55C13.4534 4.17374 13.3376 3.80835 13.1082 3.51553C12.8789 3.22272 12.5472 3.02093 12.1749 2.9412C11.8026 2.86147 11.4126 2.90762 11.0749 3.07728C10.7372 3.24694 10.4684 3.52219 10.29 3.86Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{ $failedPayments }}</p>
                                <h5 class="text-xs text-white-dark">Failed</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart: Income Per Month -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Pendapatan Per Bulan</h2>
                <div class="panel">
                    <div id="chartIncome"></div>
                </div>
            </div>

            <!-- Recent Bookings Table -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Booking Terbaru</h2>
                <div class="panel overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-300 dark:border-gray-700">
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">ID</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Klien</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Konselor</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Status</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Pembayaran</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Dibuat pada</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-3 text-sm dark:text-white-light">#{{ $booking->id }}</td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">{{ $booking->client->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">{{ $booking->counselor->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($booking->status === 'completed')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Completed</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger">Cancelled</span>
                                        @elseif($booking->status === 'rescheduled')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning">Rescheduled</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-info/10 text-info">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">
                                        @if($booking->payment && $booking->payment->status === 'success')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Paid</span>
                                        @elseif($booking->payment && $booking->payment->status === 'pending')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning">Pending</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">{{ $booking->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a
                                            href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold
                                                   bg-primary/10 text-primary rounded-md hover:bg-primary hover:text-white transition"
                                        >
                                            Lihat
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data booking</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Payments Table -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Transaksi Pembayaran Terbaru</h2>
                <div class="panel overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-300 dark:border-gray-700">
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">ID</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Klien</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Konselor</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Jumlah</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Status</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Dibuat pada</th>
                                <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-3 text-sm dark:text-white-light">#{{ $payment->id }}</td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">{{ $payment->booking->client->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">{{ $payment->booking->counselor->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold dark:text-white-light">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($payment->status === 'success')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Success</span>
                                        @elseif($payment->status === 'pending')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning">Pending</span>
                                        @elseif($payment->status === 'failed')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger">Failed</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">{{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm dark:text-white-light">{{ $payment->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a
                                            href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold
                                                   bg-primary/10 text-primary rounded-md hover:bg-primary hover:text-white transition"
                                        >
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartIncome = new ApexCharts(document.querySelector("#chartIncome"), {
                series: [{
                    name: "Pendapatan",
                    data: @json($chartIncome)
                }],
                chart: {
                    type: "area",
                    height: 350,
                    toolbar: {
                        show: true,
                    },
                    stacked: false,
                    zoom: {
                        enabled: true
                    }
                },
                colors: ['#5B4EC8'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: "smooth",
                    width: 2
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
                },
                yaxis: {
                    title: {
                        text: 'Pendapatan (Rp)'
                    },
                    labels: {
                        formatter: function(value) {
                            return 'Rp ' + Math.round(value / 1000000) + 'M';
                        }
                    }
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 100]
                    }
                }
            });

            chartIncome.render();
        });
    </script>
</x-admin.app>
