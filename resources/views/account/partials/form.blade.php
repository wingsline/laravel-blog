{{-- name --}}
<div class="mb-4 w-full">
    <label for="name">{{ __('Name') }}</label>
    <input class="text-input" id="name" type="text" autofocus value="{{ old('name', $user->name) }}" name="name">
    <p class="text-xs text-red-700 mt-1">
        @error('name') {{ $message }} @enderror
    </p>
</div>
{{-- email --}}
<div class="mb-4 w-full">
    <label for="email">{{ __('E-mail') }}</label>
    <input class="text-input" id="email" type="email" value="{{ old('email', $user->email) }}" name="email">
    <p class="text-xs text-red-700 mt-1">
        @error('email') {{ $message }} @enderror
    </p>
</div>

{{-- new password --}}
<div class="mb-4 w-full">
    <label for="password">{{ __('New Password') }}</label>
    <input class="text-input" id="password" type="password" value="" name="password">
    <p class="text-xs text-red-700 mt-1">
        @error('password') {{ $message }} @enderror
    </p>
</div>
{{-- new password confirm --}}
<div class="mb-4 w-full">
    <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
    <input class="text-input" id="password_confirmation" type="password" value="" name="password_confirmation">
    <p class="text-xs text-red-700 mt-1">
        @error('password_confirmation') {{ $message }} @enderror
    </p>
</div>
{{-- submit --}}
<div class="pt-4">
    <button type="submit" class="btn">{{ $submitText }}</button>
</div>
