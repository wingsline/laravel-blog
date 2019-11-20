<div class="flex justify-between items-center bg-gray-100 px-4 sm:px-6">
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1" stroke-linecap="round"
             stroke-linejoin="round"
             class="text-4xl sm:text-5xl text-indigo-300">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
            <path
                d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
        </svg>
        <div class="my-2 sm:my-4 ml-2 sm:ml-4">
            <h1 class="text-lg sm:text-2xl text-gray-700">{{ __($title) }}</h1>
            <p class="text-xs sm:text-sm text-gray-500">{{ __($description) }}</p>
        </div>
    </div>
    <a href="{{ route('admin.posts.create') }}"
       class="ml-2 btn flex items-center  px-3 sm:px-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round" class="sm:mr-2">
            <path
                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path
                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>
        <span class="sr-only sm:not-sr-only">New Post</span>
    </a>
</div>
