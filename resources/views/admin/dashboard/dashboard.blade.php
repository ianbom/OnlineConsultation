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
            <!-- Main Statistics Component -->
            <x-admin.main-statistics
                :totalClients="$totalClients"
                :filteredRevenue="$filteredRevenue"
                :filteredBookings="$filteredBookings"
                :filterType="$filterType"
                :filterMonth="$filterMonth"
                :filterYear="$filterYear"
            />

            <!-- Statistics Chart Component -->
            <x-admin.statistics-chart
                :chartIncome="$chartIncome"
                :chartBookings="$chartBookings"
            />

            <!-- Recent Bookings Component -->
            <x-admin.recent-bookings
                :bookings="$recentBookings"
            />
        </div>
    </div>


    <script>
        // Filter function
        function applyFilter() {
            const filterType = document.getElementById('filterType').value;
            const filterMonth = document.getElementById('filterMonth').value;
            const filterYear = document.getElementById('filterYear').value;

            // Show/hide month and year selectors based on filter type
            const monthSelect = document.getElementById('filterMonth');
            const yearSelect = document.getElementById('filterYear');

            if (filterType === 'month') {
                monthSelect.style.display = 'block';
                yearSelect.style.display = 'block';
            } else if (filterType === 'year') {
                monthSelect.style.display = 'none';
                yearSelect.style.display = 'block';
            } else {
                monthSelect.style.display = 'none';
                yearSelect.style.display = 'none';
            }

            // Build URL with parameters
            const url = new URL(window.location.href);
            url.searchParams.set('filter_type', filterType);

            if (filterType === 'month') {
                url.searchParams.set('filter_month', filterMonth);
                url.searchParams.set('filter_year', filterYear);
            } else if (filterType === 'year') {
                url.searchParams.set('filter_year', filterYear);
            } else {
                url.searchParams.delete('filter_month');
                url.searchParams.delete('filter_year');
            }

            // Reload page with new parameters
            window.location.href = url.toString();
        }
    </script>
   
</x-admin.app>
