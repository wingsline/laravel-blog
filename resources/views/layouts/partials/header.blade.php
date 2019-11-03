<header class="bg-white-50">
    <div class="flex justify-between items-center py-3 sm:py-4 container px-4 sm:px-0">
        <h1 class="text-xl sm:text-3xl leading-none tracking-tight font-light whitespace-no-wrap">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 ">Admin</a>
        </h1>

        @auth
            <nav>{{ Menu::admin() }}</nav>
        @endauth
    </div>
</header>


