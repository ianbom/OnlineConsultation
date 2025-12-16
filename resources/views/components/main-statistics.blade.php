@props(['totalClients', 'filteredRevenue', 'filteredBookings', 'filterType', 'filterMonth', 'filterYear', 'showClient'])

<!-- Stats Cards with Filter -->
<div class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold dark:text-white-light">Statistik Utama</h2>
        <div class="flex gap-2 items-center">
            <select id="filterType" class="form-select text-sm" onchange="applyFilter()">
                <option value="all" {{ $filterType == 'all' ? 'selected' : '' }}>Semua Data</option>
                <option value="last7days" {{ $filterType == 'last7days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="month" {{ $filterType == 'month' ? 'selected' : '' }}>Per Bulan</option>
                <option value="year" {{ $filterType == 'year' ? 'selected' : '' }}>Per Tahun</option>
            </select>

            <select id="filterMonth" class="form-select text-sm" onchange="applyFilter()" style="display: {{ $filterType == 'month' ? 'block' : 'none' }}">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $filterMonth == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>

            <select id="filterYear" class="form-select text-sm" onchange="applyFilter()" style="display: {{ in_array($filterType, ['month', 'year']) ? 'block' : 'none' }}">
                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $filterYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total Clients -->

        @if ($showClient == true)
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
                    <p class="text-xl dark:text-white-light">{{ $totalClients }}</p>
                    <h5 class="text-xs text-white-dark">Total Klien</h5>
                </div>
            </div>
        </div>
        @endif



        <!-- Total Revenue (Filtered) -->
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
                    <p class="text-xl dark:text-white-light">Rp {{ number_format($filteredRevenue, 0, ',', '.') }}</p>
                    <h5 class="text-xs text-white-dark">Total Pendapatan</h5>
                </div>
            </div>
        </div>

        <!-- Total Bookings (Filtered) -->
        <div class="panel h-full">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div class="w-12 h-12 rounded-full bg-warning/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-warning" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 2V6M8 2V6M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                    <p class="text-xl dark:text-white-light">{{ $filteredBookings }}</p>
                    <h5 class="text-xs text-white-dark">Total Booking</h5>
                </div>
            </div>
        </div>
    </div>
</div>
