{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>@yield('title', 'Admin Dashboard - Booking Summary')</title>

  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#7b1e2d",
            "background-light": "#f8f6f6",
            "background-dark": "#1f1315",
            "card-light": "#ffffff",
            "card-dark": "#2a1d1f",
            "border-light": "#e4ddde",
            "border-dark": "#4a3b3e",
          },
          fontFamily: {
            "display": ["Manrope", "sans-serif"]
          },
          borderRadius: {
            "DEFAULT": "0.5rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>

  <style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  </style>

  @stack('head')
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#171213] dark:text-gray-100 antialiased overflow-hidden transition-colors duration-200">
  <div class="flex h-screen w-full overflow-hidden">
    <x-admin_new.sidebar />

    <div class="flex h-full w-full flex-col overflow-hidden relative">
      <x-admin_new.header />

      {{ $slot }}

      <x-admin_new.footer />
    </div>
  </div>

  @stack('scripts')
</body>
</html>
