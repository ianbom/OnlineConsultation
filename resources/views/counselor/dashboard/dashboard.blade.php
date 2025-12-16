<x-counselor.app>
    <script defer src="/assets/js/apexcharts.js"></script>
    <div x-data="sales">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Counselor</span>
            </li>
        </ul>

        <div class="pt-5">
            <!-- Stats Cards - Counselor Specific -->
            <x-main-statistics
            :showClient="false"
            :totalClients="$totalClients"
            :filteredRevenue="$filteredRevenue"
            :filteredBookings="$filteredBookings"
            :filterType="$filterType"
            :filterMonth="$filterMonth"
            :filterYear="$filterYear"
        />

            <!-- Charts Component -->
            <x-statistics-chart
                :chartIncome="$chartIncome"
                :chartBookings="$chartBookings"
                :totalIncome="$totalIncome"
                :todayBookings="$todayBookings"
                :weeklyBookings="$weeklyBookings"
                :monthlyBookings="$monthlyBookings"
            />

            <!-- Recent Bookings Component -->
            <x-recent-bookings
                :bookings="$recentBookings"
            />
        </div>
    </div>
</x-counselor.app>
