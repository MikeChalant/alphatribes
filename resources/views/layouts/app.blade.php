<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="{{ asset('pace_loader/pace.js') }}" type="text/javascript"></script>
        <link rel="stylesheet" href="{{ asset('pace_loader/flash.css') }}">
        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="{{ asset('js/flowbite.js') }}" type="text/javascript" defer></script>
        <script src="{{ asset('js/notiflix-aio-3.2.5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/main.js') }}" type="text/javascript" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 lg:pl-72">
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="flex justify-between lg:justify-end items-center py-3 px-4 lg:px-6">
                    <button class="lg:hidden" data-drawer-target="drawer-disable-body-scrolling" data-drawer-show="drawer-disable-body-scrolling" data-drawer-body-scrolling="false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <button class="flex items-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4">
                {{ $slot }}
            </main>
            @include('layouts._sidebar')

            @include('layouts._mobile_drawer')
            @include('flash_message')
        </div>
         <script type="text/javascript" async="true">
      // Wait for document to finish loading and run domReady function
      if (document.readyState == "loading") {
        document.addEventListener("DOMContentLoaded", domReady);
      } else {
        domReady();
      }

      function domReady() {
        let drawer = document.querySelector("#drawer-disable-body-scrolling");
        if (drawer.classList.contains("hidden"))
          drawer.classList.toggle("hidden");
      }
    </script>
    </body>
</html>
