{{-- resources/views/admin/dashboard.blade.php --}}
<x-admin_new.app>

@section('title', 'Admin Dashboard - Booking Summary')

@section('content')
<main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-6 lg:px-10 lg:py-8">
  <div class="mx-auto max-w-[1400px] flex flex-col gap-8">

    {{-- Page Title + Filters --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
      <div class="flex flex-col gap-1">
        <h1 class="text-3xl md:text-4xl font-black text-[#171213] dark:text-white tracking-tight">Booking Summary</h1>
        <p class="text-[#83676c] dark:text-gray-400 text-base">Overview of booking performance and operational tasks</p>
      </div>

      <div class="flex flex-wrap items-center gap-3">
        <div class="flex bg-card-light dark:bg-card-dark p-1 rounded-lg border border-border-light dark:border-border-dark shadow-sm">
          <button class="px-3 py-1.5 rounded-md bg-primary text-white text-sm font-bold shadow-sm">This Week</button>
          <button class="px-3 py-1.5 rounded-md text-[#83676c] hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 text-sm font-medium transition-colors">This Month</button>
          <button class="px-3 py-1.5 rounded-md text-[#83676c] hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 text-sm font-medium transition-colors">Custom</button>
        </div>

        <button class="flex items-center gap-2 h-10 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark hover:bg-gray-50 dark:hover:bg-gray-800 text-[#171213] dark:text-white text-sm font-bold rounded-lg shadow-sm transition-colors">
          <span class="material-symbols-outlined text-[18px]">download</span>
          <span>Export</span>
        </button>
      </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      <div class="flex flex-col justify-between gap-4 rounded-lg bg-card-light dark:bg-card-dark p-5 border border-border-light dark:border-border-dark shadow-sm">
        <div class="flex justify-between items-start">
          <div class="flex flex-col gap-1">
            <p class="text-[#83676c] dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Total Bookings</p>
            <p class="text-[#171213] dark:text-white text-3xl font-bold tracking-tight">1,240</p>
          </div>
          <div class="p-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg">
            <span class="material-symbols-outlined">calendar_month</span>
          </div>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <span class="flex items-center text-green-600 font-bold bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded text-xs">
            <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span> 5%
          </span>
          <span class="text-[#83676c] dark:text-gray-500">vs last week</span>
        </div>
      </div>

      <div class="flex flex-col justify-between gap-4 rounded-lg bg-card-light dark:bg-card-dark p-5 border border-border-light dark:border-border-dark shadow-sm">
        <div class="flex justify-between items-start">
          <div class="flex flex-col gap-1">
            <p class="text-[#83676c] dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Pending Payment</p>
            <p class="text-[#171213] dark:text-white text-3xl font-bold tracking-tight">45</p>
          </div>
          <div class="p-2 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 rounded-lg">
            <span class="material-symbols-outlined">pending_actions</span>
          </div>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <span class="flex items-center text-orange-600 font-bold bg-orange-50 dark:bg-orange-900/20 px-2 py-0.5 rounded text-xs">
            <span class="material-symbols-outlined text-[14px] mr-1">priority_high</span> 2%
          </span>
          <span class="text-[#83676c] dark:text-gray-500">needs attention</span>
        </div>
      </div>

      <div class="flex flex-col justify-between gap-4 rounded-lg bg-card-light dark:bg-card-dark p-5 border border-border-light dark:border-border-dark shadow-sm">
        <div class="flex justify-between items-start">
          <div class="flex flex-col gap-1">
            <p class="text-[#83676c] dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Paid Bookings</p>
            <p class="text-[#171213] dark:text-white text-3xl font-bold tracking-tight">850</p>
          </div>
          <div class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded-lg">
            <span class="material-symbols-outlined">check_circle</span>
          </div>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <span class="flex items-center text-green-600 font-bold bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded text-xs">
            <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span> 8%
          </span>
          <span class="text-[#83676c] dark:text-gray-500">completion rate</span>
        </div>
      </div>

      <div class="flex flex-col justify-between gap-4 rounded-lg bg-card-light dark:bg-card-dark p-5 border border-border-light dark:border-border-dark shadow-sm">
        <div class="flex justify-between items-start">
          <div class="flex flex-col gap-1">
            <p class="text-[#83676c] dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Cancel / Refund</p>
            <p class="text-[#171213] dark:text-white text-3xl font-bold tracking-tight">32</p>
          </div>
          <div class="p-2 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 rounded-lg">
            <span class="material-symbols-outlined">cancel</span>
          </div>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <span class="flex items-center text-red-600 font-bold bg-red-50 dark:bg-red-900/20 px-2 py-0.5 rounded text-xs">
            <span class="material-symbols-outlined text-[14px] mr-1">arrow_downward</span> 1%
          </span>
          <span class="text-[#83676c] dark:text-gray-500">vs last week</span>
        </div>
      </div>

      <div class="flex flex-col justify-between gap-4 rounded-lg bg-card-light dark:bg-card-dark p-5 border border-border-light dark:border-border-dark shadow-sm">
        <div class="flex justify-between items-start">
          <div class="flex flex-col gap-1">
            <p class="text-[#83676c] dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Reschedule Pending</p>
            <p class="text-[#171213] dark:text-white text-3xl font-bold tracking-tight">15</p>
          </div>
          <div class="p-2 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 rounded-lg">
            <span class="material-symbols-outlined">event_repeat</span>
          </div>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <span class="flex items-center text-gray-600 font-bold bg-gray-100 dark:bg-gray-800 dark:text-gray-300 px-2 py-0.5 rounded text-xs">
            <span class="material-symbols-outlined text-[14px] mr-1">remove</span> 0%
          </span>
          <span class="text-[#83676c] dark:text-gray-500">stable</span>
        </div>
      </div>

      <div class="flex flex-col justify-between gap-4 rounded-lg bg-card-light dark:bg-card-dark p-5 border border-border-light dark:border-border-dark shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-primary/5 to-transparent pointer-events-none"></div>
        <div class="flex justify-between items-start z-10">
          <div class="flex flex-col gap-1">
            <p class="text-[#83676c] dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Total Revenue</p>
            <p class="text-primary dark:text-white text-3xl font-black tracking-tight">$124,500</p>
          </div>
          <div class="p-2 bg-primary/10 text-primary rounded-lg">
            <span class="material-symbols-outlined">payments</span>
          </div>
        </div>
        <div class="flex items-center gap-2 text-sm z-10">
          <span class="flex items-center text-green-600 font-bold bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded text-xs">
            <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span> 12%
          </span>
          <span class="text-[#83676c] dark:text-gray-500">healthy growth</span>
        </div>
      </div>
    </div>

    {{-- Chart + Recent + Needs Attention --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
      <div class="xl:col-span-2 flex flex-col gap-6">

        {{-- Booking per Day --}}
        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-lg p-6 shadow-sm">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-[#171213] dark:text-white">Booking per Day</h3>
            <button class="p-2 hover:bg-background-light dark:hover:bg-gray-800 rounded-lg text-[#83676c] transition-colors">
              <span class="material-symbols-outlined">more_horiz</span>
            </button>
          </div>

          {{-- chart bars (dummy) --}}
          <div class="h-64 flex items-end justify-between gap-2 sm:gap-4 w-full pt-4">
            {{-- ... (isi bar sama seperti HTML kamu) --}}
            {{-- Aku biarkan persis dari HTML, kamu bisa tetap pakai block ini tanpa perubahan --}}
            @php
              // placeholder supaya tidak error jika kamu ingin nanti generate data dinamis
            @endphp

            <div class="flex flex-col items-center gap-2 group flex-1">
              <div class="w-full bg-primary/20 dark:bg-primary/30 rounded-t-md h-[40%] group-hover:bg-primary transition-all relative">
                <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded pointer-events-none transition-opacity">12</div>
              </div>
              <span class="text-xs text-[#83676c]">M</span>
            </div>

            {{-- (bar lain tetap copy dari HTML kamu jika mau) --}}
          </div>
        </div>

        {{-- Recent Bookings --}}
        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-lg shadow-sm flex flex-col">
          <div class="p-6 pb-2 flex justify-between items-center">
            <h3 class="text-lg font-bold text-[#171213] dark:text-white">Recent Bookings</h3>
            <a class="text-sm font-bold text-primary hover:underline" href="#">View All</a>
          </div>

          <div class="overflow-x-auto p-2">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr>
                  <th class="p-4 text-xs font-semibold text-[#83676c] dark:text-gray-400 uppercase tracking-wider">ID</th>
                  <th class="p-4 text-xs font-semibold text-[#83676c] dark:text-gray-400 uppercase tracking-wider">Client</th>
                  <th class="p-4 text-xs font-semibold text-[#83676c] dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Counselor</th>
                  <th class="p-4 text-xs font-semibold text-[#83676c] dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Date &amp; Time</th>
                  <th class="p-4 text-xs font-semibold text-[#83676c] dark:text-gray-400 uppercase tracking-wider">Status</th>
                  <th class="p-4 text-xs font-semibold text-[#83676c] dark:text-gray-400 uppercase tracking-wider text-right">Action</th>
                </tr>
              </thead>

              <tbody class="text-sm divide-y divide-border-light dark:divide-border-dark">
                {{-- rows dummy (copy dari HTML kamu) --}}
                <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                  <td class="p-4 font-medium text-[#171213] dark:text-white">#BK-2094</td>
                  <td class="p-4">
                    <div class="flex items-center gap-3">
                      <div class="size-8 rounded-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAeMtimPguHnEN-v4vkua7vXamCoz2-AjLt7J1jex6fr5npZzBgbmgNVQVtnHbgIKB9Vefk_gxjzv0TUlwapNS5gMlgigXZ-_P2b4JJJodCfK2-BXEff3tUzOLTKR62A0X4DFVC0AMAW_RlvrkmJxl6IcDxC69GsZk6p8tIGFaVudnQCq0su0KJyhGYfsMY0N622lQ_2cq6ToRy5MMxRW2rj9tc-lXySlDE826yz3eRsIqIOXjKHaoOBvs3CYClcxqOEKeHAbhFecc');"></div>
                      <span class="font-medium text-[#171213] dark:text-white">Sarah Jenkins</span>
                    </div>
                  </td>
                  <td class="p-4 text-[#83676c] dark:text-gray-400 hidden md:table-cell">Dr. Emily Stone</td>
                  <td class="p-4 text-[#83676c] dark:text-gray-400 hidden lg:table-cell">Oct 24, 10:00 AM</td>
                  <td class="p-4">
                    <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Confirmed</span>
                  </td>
                  <td class="p-4 text-right">
                    <button class="text-primary hover:text-[#5e1622] dark:hover:text-red-300 font-bold text-xs border border-primary/20 hover:border-primary rounded-lg px-3 py-1.5 transition-colors">View Detail</button>
                  </td>
                </tr>

                {{-- (row lain copy sesuai kebutuhan) --}}
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- Needs Attention --}}
      <div class="xl:col-span-1">
        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-lg shadow-sm h-full flex flex-col">
          <div class="p-6 pb-4 border-b border-border-light dark:border-border-dark">
            <h3 class="text-lg font-bold text-[#171213] dark:text-white mb-4">Needs Attention</h3>

            <div class="flex gap-2 p-1 bg-background-light dark:bg-gray-800 rounded-lg">
              <button class="flex-1 py-1.5 px-2 text-xs font-bold text-center rounded bg-white dark:bg-card-dark shadow-sm text-primary transition-all">Reschedule</button>
              <button class="flex-1 py-1.5 px-2 text-xs font-medium text-center rounded hover:bg-white/50 dark:hover:bg-gray-700 text-[#83676c] dark:text-gray-400 transition-all">Payments</button>
              <button class="flex-1 py-1.5 px-2 text-xs font-medium text-center rounded hover:bg-white/50 dark:hover:bg-gray-700 text-[#83676c] dark:text-gray-400 transition-all">Refunds</button>
            </div>
          </div>

          <div class="p-4 flex flex-col gap-3 flex-1 overflow-y-auto max-h-[500px] hide-scrollbar">
            {{-- card item --}}
            <div class="p-4 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 hover:border-primary/30 transition-colors cursor-pointer">
              <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2">
                  <span class="material-symbols-outlined text-orange-500 text-[18px]">schedule</span>
                  <span class="text-xs font-bold text-orange-600 dark:text-orange-400 uppercase">Reschedule Request</span>
                </div>
                <span class="text-[10px] text-[#83676c]">2m ago</span>
              </div>
              <p class="text-sm font-semibold text-[#171213] dark:text-white mb-1">Client John Doe</p>
              <p class="text-xs text-[#83676c] dark:text-gray-400 mb-3 line-clamp-2">Requested to move session #BK-2099 from Oct 25 to Oct 27 due to conflict.</p>
              <div class="flex gap-2">
                <button class="flex-1 py-1.5 bg-primary text-white text-xs font-bold rounded hover:bg-[#5e1622] transition-colors">Review</button>
                <button class="flex-1 py-1.5 bg-white dark:bg-transparent border border-border-light dark:border-gray-600 text-[#171213] dark:text-gray-300 text-xs font-bold rounded hover:bg-gray-50 transition-colors">Dismiss</button>
              </div>
            </div>

            {{-- item lain copy dari HTML kamu --}}
          </div>

          <div class="p-4 border-t border-border-light dark:border-border-dark">
            <button class="w-full py-2 text-sm text-primary font-bold hover:underline">View All Requests</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

</x-admin_new.app>
