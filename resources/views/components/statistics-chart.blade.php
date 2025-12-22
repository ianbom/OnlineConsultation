@props(['chartIncome', 'chartBookings'])

<!-- Charts Section with Toggle -->
<div class="mb-6">
    <div class="panel">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-white-light">Grafik Statistik</h2>
            <div class="flex gap-2">
                <button
                    onclick="switchChart('income')"
                    id="btn-income"
                    class="px-4 py-2 text-sm rounded-md bg-primary text-white transition"
                >
                    Pendapatan
                </button>
                <button
                    onclick="switchChart('booking')"
                    id="btn-booking"
                    class="px-4 py-2 text-sm rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 transition"
                >
                    Booking
                </button>
            </div>
        </div>
        <div id="chartIncome"></div>
        <div id="chartBookings" style="display: none;"></div>
    </div>
</div>

<script>
    let chartIncome, chartBookings;

    document.addEventListener('DOMContentLoaded', function() {
        // Chart Income
        chartIncome = new ApexCharts(document.querySelector("#chartIncome"), {
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

        // Chart Bookings
        chartBookings = new ApexCharts(document.querySelector("#chartBookings"), {
            series: [{
                name: "Bookings",
                data: @json($chartBookings)
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
            colors: ['#00AB55'],
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
                    text: 'Jumlah Booking'
                }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(value) {
                        return value + ' bookings';
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

        chartBookings.render();
    });

    // Switch Chart function
    function switchChart(type) {
        const incomeChart = document.getElementById('chartIncome');
        const bookingChart = document.getElementById('chartBookings');
        const btnIncome = document.getElementById('btn-income');
        const btnBooking = document.getElementById('btn-booking');

        if (type === 'income') {
            incomeChart.style.display = 'block';
            bookingChart.style.display = 'none';

            btnIncome.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            btnIncome.classList.add('bg-primary', 'text-white');

            btnBooking.classList.remove('bg-primary', 'text-white');
            btnBooking.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');

            // Trigger resize for income chart
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 100);
        } else {
            incomeChart.style.display = 'none';
            bookingChart.style.display = 'block';

            btnBooking.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            btnBooking.classList.add('bg-primary', 'text-white');

            btnIncome.classList.remove('bg-primary', 'text-white');
            btnIncome.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');

            // Trigger resize for booking chart
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 100);
        }
    }
</script>
