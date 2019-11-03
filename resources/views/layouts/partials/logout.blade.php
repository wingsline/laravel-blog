<button
    type="submit"
    form="logout-form"
    data-confirm="{{ __('Are you sure you want to sign out?') }}"
    class="bg-transparent text-orange-500 hover:text-orange-700 p-0 normal-case font-normal text-base ml-2"
    >
    {{ __('Sign Out') }}
</button>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
    @csrf
</form>
