<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="bg-white text-base">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, viewport-fit=cover, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | {{ config('app.name') }}</title>

    <!-- Styles -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet"
          href="{{ asset(mix('main.css', 'vendor/wingsline-blog')) }}">
</head>
<body class="min-h-screen">
<div class="min-h-screen flex flex-col" id="app">
    <header class="border-b">
        <div class="container flex px-4 py-5 items-center">
            @auth
                <button type="button" class="mr-2 bg-transparent p-0 lg:sr-only" aria-controls="admin-nav" data-toggle-handler="toggleAdminNav" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="text-gray-600 ">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="hidden text-gray-600">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            @endauth
            <div class="w-1/4">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-lg flex items-center uppercase tracking-wider text-orange-500 lg:text-gray-600 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em"
                         height="1.5em" viewBox="0 0 28 28"
                         class="mr-6 flex-shrink-0 sr-only lg:not-sr-only lg:pl-2">
                        <path fill="#FF830D"
                              d="M4.633 20.089s.22-8.119-1.936-17.722c2.505.962 12.299 5.592 13.288 9.528 0 0 .032 9.387.022 16.384-3.074-3.535-5.835-5.856-11.375-8.19 0 0 5.539 2.333 0 0zm12.852 3.877s-.18-12.328-.112-12.344c-.582-2.625-4.924-5.65-4.924-5.65s6.319 1.433 10.987 1.613c-1.761 9.455-.714 13.52-.181 19.164-1.967-1.008-3.885-2.109-5.77-2.784 0 0 1.885.675 0 0zM5.527 2.063C14.582 2 20.268.823 20.268.823s-.894 2.12-1.266 4.869c-1.787.079-10.831-1.926-13.474-3.629 0 0 2.643 1.702 0 0z"/>
                    </svg>
                    <span class="inline-block ml-2">Admin</span>
                </a>
            </div>
            <div class="flex-grow flex justify-center"></div>
            <div class="w-1/4 flex justify-end items-center text-xl">
                @auth
                    <nav>{{ \Spatie\Menu\Laravel\Facades\Menu::blogAdminNavHeader() }}</nav>
                @endauth
            </div>
        </div>
    </header>
    <div class="lg:flex lg:flex-1 container">
        @auth
            <aside class="z-50 lg:z-0 fixed lg:block inset-0 mt-16 lg:mt-0 bg-white px-8 py-5 sr-only lg:not-sr-only lg:w-1/4" id="admin-nav" aria-expanded="false">
                <nav class="px-4 h-full overflow-auto">
                    {{ \Spatie\Menu\Laravel\Facades\Menu::blogAdminNav() }}
                </nav>
            </aside>
        @endauth
        <main class="w-full flex-1 px-4  py-5">
            @yield('content')
        </main>
    </div>
</div>
<script nonce="{{ csp_nonce() }}"
        src="{{ asset(mix('manifest.js', 'vendor/wingsline-blog')) }}"></script>
<script nonce="{{ csp_nonce() }}"
        src="{{ asset(mix('vendor.js', 'vendor/wingsline-blog')) }}"></script>
<script nonce="{{ csp_nonce() }}"
        src="{{ asset(mix('app.js', 'vendor/wingsline-blog')) }}"></script>
</body>
</html>
