<x-admin.app>
    <script defer src="/assets/js/apexcharts.js"></script>
    <div x-data="sales">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Client</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Detail</span>
            </li>
        </ul>

        <div class="pt-5">
            <!-- Client Profile Section -->
            <div class="mb-6">
                <div class="panel">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <!-- Profile Picture -->
                        <div class="shrink-0">
                            @if($client->profile_pic)
                                <img class="w-24 h-24 rounded-full object-cover border-4 border-primary/20"
                                    src="{{ asset('storage/' . $client->profile_pic) }}" alt="profile" />
                            @else
                                <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center border-4 border-primary/20">
                                    <span class="text-3xl font-semibold text-primary">{{ substr($client->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold dark:text-white-light mb-2">{{ $client->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $client->phone ?? 'No phone number' }}</p>

                            <!-- Status Badge -->
                            <div class="flex items-center gap-3 flex-wrap">
                                @if($client->email_verified_at)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Verified</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning">Unverified</span>
                                @endif

                                <div class="text-sm dark:text-white-light">
                                    <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                    <a href="mailto:{{ $client->email }}" class="text-primary hover:underline ml-1">{{ $client->email }}</a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex flex-col gap-2">
                            {{-- Tertiary / Back Action --}}
                            <a href="{{ route('admin.client.index') }}"
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

        <div class="pt-5">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
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
                            <h5 class="text-xs text-white-dark">Booking</h5>
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
                            <h5 class="text-xs text-white-dark">Booking</h5>
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
                            <h5 class="text-xs text-white-dark">Booking</h5>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings -->
                <div class="panel h-full">
                    <div class="flex justify-between items-center mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">Selesai</h5>
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
                            <p class="text-xl dark:text-white-light">{{ $completedBookings }}</p>
                            <h5 class="text-xs text-white-dark">Sessions</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid xl:grid-cols-3 gap-6 mb-6">
                <div class="panel h-full xl:col-span-2">
                    <div class="flex items-center dark:text-white-light mb-5">
                        <h5 class="font-semibold text-lg">Spending Overview</h5>
                    </div>
                    <p class="text-lg dark:text-white-light/90">Total Spending <span
                            class="text-primary ml-2">Rp {{ number_format($totalSpending, 0, ',', '.') }}</span></p>
                    <div class="relative overflow-hidden">
                        <div x-ref="revenueChart" class="bg-white dark:bg-black rounded-lg">
                            <!-- loader -->
                            <div
                                class="min-h-[325px] grid place-content-center bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] ">
                                <span
                                    class="animate-spin border-2 border-black dark:border-white !border-l-transparent  rounded-full w-5 h-5 inline-flex"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel h-full">
                    <div class="flex items-center mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">Booking Status</h5>
                    </div>
                    <div class="overflow-hidden">
                        <div x-ref="salesByCategory" class="bg-white dark:bg-black rounded-lg">
                            <!-- loader -->
                            <div
                                class="min-h-[353px] grid place-content-center bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] ">
                                <span
                                    class="animate-spin border-2 border-black dark:border-white !border-l-transparent  rounded-full w-5 h-5 inline-flex"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-1 grid-cols-1 gap-6">
                <div class="panel h-full w-full">
                    <div class="flex items-center justify-between mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">Recent Bookings</h5>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">Client</th>
                                    <th>Type</th>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th class="ltr:rounded-r-md rtl:rounded-l-md">Booking Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr class="text-gray-700 dark:text-white-dark hover:bg-primary/5 group">
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">
                                            @if($booking->client->profile_pic)
                                                <img class="w-8 h-8 rounded-md ltr:mr-3 rtl:ml-3 object-cover"
                                                    src="{{ asset('storage/' . $booking->client->profile_pic) }}" alt="avatar" />
                                            @else
                                                <div class="w-8 h-8 rounded-md ltr:mr-3 rtl:ml-3 bg-primary/10 flex items-center justify-center">
                                                    <span class="text-primary font-semibold">{{ substr($booking->client->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <span class="whitespace-nowrap">{{ $booking->client->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($booking->consultation_type == 'online')
                                            <span class="text-primary">Online</span>
                                        @else
                                            <span class="text-info">Offline</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->payment && $booking->payment->order_id)
                                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="text-primary hover:underline">
                                                {{ $booking->payment->order_id }}
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($booking->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($booking->payment)

                                            {{-- SUCCESS --}}
                                            @if($booking->payment->status === 'success')
                                                <span class="badge bg-success shadow-md">
                                                    Paid
                                                </span>

                                            {{-- REFUND IN PROCESS --}}
                                            @elseif($booking->payment->status === 'refund')
                                                <span class="badge bg-warning shadow-md">
                                                    Refund Diproses
                                                </span>

                                            {{-- REFUNDED --}}
                                            @elseif($booking->payment->status === 'refunded')
                                                <span class="badge bg-info shadow-md">
                                                    Refunded
                                                </span>

                                            {{-- PENDING PAYMENT --}}
                                            @elseif(
                                                $booking->payment->status === 'pending' &&
                                                $booking->payment->transaction_status === 'pending'
                                            )
                                                <span class="badge bg-warning shadow-md">
                                                    Pending
                                                </span>

                                            {{-- EXPIRED --}}
                                            @elseif(
                                                $booking->payment->status === 'pending' &&
                                                in_array($booking->payment->transaction_status, ['expire', 'expired'])
                                            )
                                                <span class="badge bg-secondary shadow-md">
                                                    Expired
                                                </span>

                                            {{-- FAILED / DENY --}}
                                            @elseif(
                                                in_array($booking->payment->status, ['failed']) ||
                                                in_array($booking->payment->transaction_status, ['deny', 'cancel'])
                                            )
                                                <span class="badge bg-danger shadow-md">
                                                    Failed
                                                </span>

                                            {{-- FALLBACK --}}
                                            @else
                                                <span class="badge bg-dark shadow-md">
                                                    {{ ucfirst($booking->payment->status) }}
                                                </span>

                                            @endif

                                        @else
                                            <span class="badge bg-secondary shadow-md">
                                                No Payment
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($booking->status == 'completed')
                                            <span class="badge bg-success shadow-md dark:group-hover:bg-transparent">Completed</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge bg-info shadow-md dark:group-hover:bg-transparent">Confirmed</span>
                                        @elseif($booking->status == 'paid')
                                            <span class="badge bg-primary shadow-md dark:group-hover:bg-transparent">Paid</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge bg-danger shadow-md dark:group-hover:bg-transparent">Cancelled</span>
                                        @elseif($booking->status == 'rescheduled')
                                            <span class="badge bg-warning shadow-md dark:group-hover:bg-transparent">Rescheduled</span>
                                        @else
                                            <span class="badge bg-gray-700 shadow-md dark:group-hover:bg-transparent">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-white-dark py-4">
                                        No recent bookings found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("sales", () => ({
                init() {
                    isDark = this.$store.app.theme === "dark" || this.$store.app.isDarkMode ? true : false;
                    isRtl = this.$store.app.rtlClass === "rtl" ? true : false;

                    const revenueChart = null;
                    const salesByCategory = null;

                    // Data dari controller
                    const chartSpendingData = @json($chartSpending);

                    setTimeout(() => {
                        this.revenueChart = new ApexCharts(this.$refs.revenueChart, this.revenueChartOptions(chartSpendingData))
                        this.$refs.revenueChart.innerHTML = "";
                        this.revenueChart.render()

                        this.salesByCategory = new ApexCharts(this.$refs.salesByCategory, this.salesByCategoryOptions)
                        this.$refs.salesByCategory.innerHTML = "";
                        this.salesByCategory.render()
                    }, 300);

                    this.$watch('$store.app.theme', () => {
                        isDark = this.$store.app.theme === "dark" || this.$store.app.isDarkMode ? true : false;
                        this.revenueChart.updateOptions(this.revenueChartOptions(chartSpendingData));
                        this.salesByCategory.updateOptions(this.salesByCategoryOptions);
                    });

                    this.$watch('$store.app.rtlClass', () => {
                        isRtl = this.$store.app.rtlClass === "rtl" ? true : false;
                        this.revenueChart.updateOptions(this.revenueChartOptions(chartSpendingData));
                    });
                },

                // revenue chart dengan data dinamis
                revenueChartOptions(spendingData) {
                    return {
                        series: [{
                            name: 'Spending',
                            data: spendingData
                        }],
                        chart: {
                            height: 325,
                            type: "area",
                            fontFamily: 'Nunito, sans-serif',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            curve: 'smooth',
                            width: 2,
                            lineCap: 'square'
                        },
                        dropShadow: {
                            enabled: true,
                            opacity: 0.2,
                            blur: 10,
                            left: -7,
                            top: 22
                        },
                        colors: isDark ? ['#2196f3'] : ['#1b55e2'],
                        markers: {
                            discrete: [{
                                seriesIndex: 0,
                                dataPointIndex: 6,
                                fillColor: '#1b55e2',
                                strokeColor: 'transparent',
                                size: 7
                            }],
                        },
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        xaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                show: true
                            },
                            labels: {
                                offsetX: isRtl ? 2 : 0,
                                offsetY: 5,
                                style: {
                                    fontSize: '12px',
                                    cssClass: 'apexcharts-xaxis-title'
                                }
                            },
                        },
                        yaxis: {
                            tickAmount: 7,
                            labels: {
                                formatter: (value) => {
                                    return 'Rp ' + (value / 1000) + 'K';
                                },
                                offsetX: isRtl ? -30 : -10,
                                offsetY: 0,
                                style: {
                                    fontSize: '12px',
                                    cssClass: 'apexcharts-yaxis-title'
                                },
                            },
                            opposite: isRtl ? true : false,
                        },
                        grid: {
                            borderColor: isDark ? '#191e3a' : '#e0e6ed',
                            strokeDashArray: 5,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            padding: {
                                top: 0,
                                right: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            fontSize: '16px',
                            markers: {
                                width: 10,
                                height: 10,
                                offsetX: -2,
                            },
                            itemMargin: {
                                horizontal: 10,
                                vertical: 5
                            },
                        },
                        tooltip: {
                            marker: {
                                show: true
                            },
                            x: {
                                show: false
                            }
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                inverseColors: !1,
                                opacityFrom: isDark ? 0.19 : 0.28,
                                opacityTo: 0.05,
                                stops: isDark ? [100, 100] : [45, 100],
                            },
                        },
                    }
                },

                // sales by category
                get salesByCategoryOptions() {
                    const todayCount = {{ $todayBookings }};
                    const weeklyCount = {{ $weeklyBookings }};
                    const monthlyCount = {{ $monthlyBookings }};

                    return {
                        series: [todayCount, weeklyCount, monthlyCount],
                        chart: {
                            type: 'donut',
                            height: 460,
                            fontFamily: 'Nunito, sans-serif',
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 25,
                            colors: isDark ? '#0e1726' : '#fff'
                        },
                        colors: isDark ? ['#5c1ac3', '#e2a03f', '#e7515a'] : ['#e2a03f', '#5c1ac3', '#e7515a'],
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            fontSize: '14px',
                            markers: {
                                width: 10,
                                height: 10,
                                offsetX: -2,
                            },
                            height: 50,
                            offsetY: 20,
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '65%',
                                    background: 'transparent',
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontSize: '29px',
                                            offsetY: -10
                                        },
                                        value: {
                                            show: true,
                                            fontSize: '26px',
                                            color: isDark ? '#bfc9d4' : undefined,
                                            offsetY: 16,
                                            formatter: (val) => {
                                                return val;
                                            },
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            color: '#888ea8',
                                            fontSize: '29px',
                                            formatter: (w) => {
                                                return w.globals.seriesTotals.reduce(function(a, b) {
                                                    return a + b;
                                                }, 0);
                                            },
                                        },
                                    },
                                },
                            },
                        },
                        labels: ['Today', 'This Week', 'This Month'],
                        states: {
                            hover: {
                                filter: {
                                    type: 'none',
                                    value: 0.15,
                                }
                            },
                            active: {
                                filter: {
                                    type: 'none',
                                    value: 0.15,
                                }
                            },
                        }
                    }
                }
            }));
        });
    </script>
</x-admin.app>
