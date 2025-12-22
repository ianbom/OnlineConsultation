{{-- resources/views/partials/sidebar.blade.php --}}
<aside class="hidden lg:flex flex-col w-64 bg-card-light dark:bg-card-dark border-r border-border-light dark:border-border-dark shrink-0 z-30">
  <div class="h-16 flex items-center gap-3 px-6 border-b border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark">
    <div class="flex items-center justify-center size-8 bg-primary/10 rounded-lg text-primary">
      <span class="material-symbols-outlined text-xl">spa</span>
    </div>
    <h2 class="text-lg font-extrabold tracking-tight text-[#171213] dark:text-white">Admin Panel</h2>
  </div>

  <nav class="flex-1 overflow-y-auto p-4 space-y-1">
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary text-white shadow-md transition-colors group" href="#">
      <span class="material-symbols-outlined text-[20px]">dashboard</span>
      <span class="text-sm font-bold">Dashboard</span>
    </a>

    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#83676c] dark:text-gray-400 hover:bg-background-light dark:hover:bg-gray-800 hover:text-primary dark:hover:text-white transition-colors group" href="#">
      <span class="material-symbols-outlined text-[20px] group-hover:text-primary dark:group-hover:text-white transition-colors">calendar_month</span>
      <span class="text-sm font-medium">Bookings</span>
    </a>

    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#83676c] dark:text-gray-400 hover:bg-background-light dark:hover:bg-gray-800 hover:text-primary dark:hover:text-white transition-colors group" href="#">
      <span class="material-symbols-outlined text-[20px] group-hover:text-primary dark:group-hover:text-white transition-colors">payments</span>
      <span class="text-sm font-medium">Payments</span>
    </a>

    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#83676c] dark:text-gray-400 hover:bg-background-light dark:hover:bg-gray-800 hover:text-primary dark:hover:text-white transition-colors group" href="#">
      <span class="material-symbols-outlined text-[20px] group-hover:text-primary dark:group-hover:text-white transition-colors">clinical_notes</span>
      <span class="text-sm font-medium">Counselors</span>
    </a>

    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#83676c] dark:text-gray-400 hover:bg-background-light dark:hover:bg-gray-800 hover:text-primary dark:hover:text-white transition-colors group" href="#">
      <span class="material-symbols-outlined text-[20px] group-hover:text-primary dark:group-hover:text-white transition-colors">group</span>
      <span class="text-sm font-medium">Clients</span>
    </a>

    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#83676c] dark:text-gray-400 hover:bg-background-light dark:hover:bg-gray-800 hover:text-primary dark:hover:text-white transition-colors group" href="#">
      <span class="material-symbols-outlined text-[20px] group-hover:text-primary dark:group-hover:text-white transition-colors">assignment_return</span>
      <span class="text-sm font-medium">Refund Requests</span>
    </a>
  </nav>

  <div class="p-4 border-t border-border-light dark:border-border-dark">
    <button class="flex w-full items-center gap-3 px-3 py-2.5 rounded-lg text-[#83676c] dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-colors">
      <span class="material-symbols-outlined text-[20px]">logout</span>
      <span class="text-sm font-medium">Log Out</span>
    </button>
  </div>
</aside>
