{{-- title --}}
<div class="mb-4 w-full">
    <label for="title">{{ __('Title') }}</label>
    <input class="text-input" id="title" type="text" autofocus value="{{ old('title', $post->title) }}" name="title">
    <p class="text-xs text-red-700 mt-1">
        @error('title') {{ $message }} @enderror
    </p>
</div>
{{-- post --}}
<div class="mb-4 w-full">
    <label for="text">{{ __('Text') }}</label>
    <textarea
        name="text"
        id="text"
        rows="15"
        class="text-input markdown-editor"
        data-upload-url="{{ $post->exists ? route('admin.posts.upload', $post): '' }}"
        data-max-size="{{ config('medialibrary.max_file_size') }}"
    >{{ old('text', $post->markdown) }}</textarea>
    <p class="text-xs text-red-700 mt-1">
        @error('text') {{ $message }} @enderror
    </p>
</div>
{{-- tags --}}
<div class="mb-4 w-full sm:w-2/3 sm:pr-4">
    <label for="tags_text">{{ __('Tags') }}</label>
    <input class="text-input" id="tags_text" type="text" value="{{ old('tags_text', $post->tags_text) }}" name="tags_text">
    <p class="text-xs text-red-700 mt-1">
        @error('tags_text') {{ $message }} @enderror
    </p>
</div>
{{-- publish date --}}
<div class="mb-4 w-full sm:w-1/3">
    <label for="publish_date">{{ __('Publish Date') }}</label>
    <input class="text-input" id="publish_date" type="text" value="{{ old('publish_date', $post->publish_date->format('Y-m-d H:i:s')) }}" name="publish_date">
    <p class="text-xs text-red-700 mt-1">
        @error('publish_date') {{ $message }} @enderror
    </p>
</div>
{{-- external url --}}
<div class="mb-4 w-full sm:w-2/3 sm:pr-4">
    <label for="external_url">{{ __('External URL') }}</label>
    <input class="text-input" id="external_url" type="text" value="{{ old('external_url', $post->external_url) }}" name="external_url">
    <p class="text-xs text-red-700 mt-1">
        @error('external_url') {{ $message }} @enderror
    </p>
</div>
{{-- published --}}
<div class="mb-4 w-full sm:w-1/6 flex items-center sm:pt-6">
    <input class="mr-2" name="published" id="published" value="1" type="checkbox" {{ $post->published ? 'checked' : '' }}>
    <label for="published" class="m-0">{{ __('Published') }}</label>
    <p class="text-xs text-red-700 mt-1">
        @error('published') {{ $message }} @enderror
    </p>
</div>
{{-- original content --}}
<div class="mb-4 w-full sm:w-1/6 flex items-center sm:pt-6">
    <input class="mr-2" name="original_content" id="original_content" value="1" type="checkbox" {{ $post->original_content ? 'checked' : '' }}>
    <label for="original_content" class="m-0">{{ __('Original content') }}</label>
    <p class="text-xs text-red-700 mt-1">
        @error('original_content') {{ $message }} @enderror
    </p>
</div>

{{-- submit --}}
<div class="mt-2">
    <button type="submit" class="btn">{{ $submitText }}</button>
</div>
