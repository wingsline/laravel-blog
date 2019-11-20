@extends('blog::layouts.master')

@section('content')
<div class="w-full justify-center items-center sm:items-start flex pt-12">
    <form class="w-full sm:w-auto rounded px-8  pb-8 sm:mt-40 border-gray-400" method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="mb-4">
            <label for="email">
                {{ __('E-Mail Address') }}
            </label>
            <input class="text-input" id="email" type="email" placeholder="admin@example.com" autofocus value="{{ old('email') }}" name="email">
            <p class="text-xs text-red-700 mt-1">
                @error('email') {{ $message }} @enderror
            </p>
        </div>
        <div class="mb-6">
            <label for="password">
                {{ __('Password') }}
            </label>
            <input class="text-input" id="password" type="password" placeholder="*****" name="password">
            <p class="text-xs text-red-700 mt-1">
                @error('password') {{ $message }} @enderror
                &nbsp;
            </p>
        </div>
        <div class="flex items-center justify-between">
            <button class="btn px-10 w-full" type="submit">
                {{ __('Sign In') }}
            </button>
        </div>
    </form>
</div>
@endsection
