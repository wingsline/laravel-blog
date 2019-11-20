<div class="leading-none">
<button
    type="submit"
    form="logout-form"
    data-confirm="{{ __('Are you sure you want to sign out?') }}"
    class="bg-transparent text-orange-500 hover:text-orange-700 p-0 normal-case text-xl text-base align-text-bottom"
    >
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round"
         width="1em" height="1em"
         stroke-linejoin="round">
        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
        <line x1="12" y1="2" x2="12" y2="12"></line>
    </svg>
    <span class="sr-only">{{ __('Sign Out') }}</span>
</button>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
    @csrf
</form>
</div>
