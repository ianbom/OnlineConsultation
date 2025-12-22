{{-- resources/views/partials/header.blade.php --}}
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark px-6 py-3 z-10 shadow-sm shrink-0 h-16">
  <div class="flex items-center gap-4 w-full">
    <button class="lg:hidden flex items-center justify-center rounded-lg size-10 text-[#83676c] hover:bg-background-light dark:hover:bg-gray-800">
      <span class="material-symbols-outlined text-xl">menu</span>
    </button>

    <div class="hidden md:flex w-full max-w-sm items-center h-10 rounded-lg bg-background-light dark:bg-background-dark border border-transparent focus-within:border-primary/20 transition-all">
      <div class="text-[#83676c] flex items-center justify-center pl-3">
        <span class="material-symbols-outlined text-xl">search</span>
      </div>
      <input
        class="w-full bg-transparent border-none text-sm px-3 text-[#171213] dark:text-white placeholder:text-[#83676c] focus:ring-0"
        placeholder="Search bookings, clients..."
      />
    </div>
  </div>

  <div class="flex items-center gap-4 md:gap-6 ml-4">
    <div class="flex gap-3">
      <button class="flex items-center justify-center rounded-lg size-10 bg-background-light dark:bg-background-dark text-[#171213] dark:text-white hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors relative">
        <span class="material-symbols-outlined text-[20px]">notifications</span>
        <span class="absolute top-2 right-2 size-2.5 bg-red-500 border-2 border-white dark:border-card-dark rounded-full"></span>
      </button>

      <button class="flex items-center justify-center rounded-lg size-10 bg-background-light dark:bg-background-dark text-[#171213] dark:text-white hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors">
        <span class="material-symbols-outlined text-[20px]">settings</span>
      </button>
    </div>

    <div class="h-8 w-px bg-border-light dark:bg-border-dark hidden md:block"></div>

    <div class="flex items-center gap-3">
      <div class="hidden md:flex flex-col items-end">
        <span class="text-sm font-bold text-[#171213] dark:text-white leading-none">Admin User</span>
        <span class="text-xs text-[#83676c] mt-1 leading-none">Super Admin</span>
      </div>

      <div
        class="size-10 rounded-full bg-cover bg-center border-2 border-white shadow-sm cursor-pointer"
        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAj5hZvzKdsWmq11mTGnqWKrjIZhnonYMQCb8dk2CpXnJ9IfOKYHn-89GsQ_pa1BKlTw4WxQmVIalnSjaXnVpApu1uUwBzlwFbDtwNdV6opyHgfF7DW3OPiRQO6w2_K00MiK1DgyJKfJCde0Hswmrop0EdCsu_wj-anNdhFfZC9QtgmAxiC_yXDKuNVokDHcMJNTy8flsGR-7g6C1z410JEbx-t8VpIreouO128kwMGeoJvvCI0a1oAsYahPf6xOcKWgMFYkt-_kKU');"
      ></div>
    </div>
  </div>
</header>
