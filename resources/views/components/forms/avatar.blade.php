<div {{ $attributes }}>
    <label
        for="{{ $name }}"
        class="cursor-pointer"
    >
        <div
            class="flex justify-center items-center w-32 h-32 mx-auto border rounded-full relative bg-gray-100 shadow-inset">
            <div wire:loading.remove wire:target="{{ $name }}"
                 class="absolute w-full h-full bg-gray-700 rounded-full opacity-0 hover:opacity-75 text-white flex justify-center items-center">
                {{ __('Upload') }}
            </div>
            <x-spinners.circle :target="$name" class="w-10 text-tawrid-secondary"></x-spinners.circle>
            <div wire:loading.remove wire:target="{{ $name }}"
                 class="object-cover w-full h-full rounded-full flex justify-center items-center">
                @if($image)
                    @if(is_string($image))
                        <img id="img-{{$name}}" src="{{ asset('storage/'.$image) }}"
                             class="object-cover w-full h-32 rounded-full">
                    @else
                        <img id="img-{{$name}}" src="{{ $image->temporaryUrl() }}"
                             class="object-cover w-full h-32 rounded-full">
                    @endif
                @else
                    <span class="bx bx-image text-gray-500 text-3xl"></span>
                @endif
            </div>
        </div>
    </label>
    <input id="{{ $name }}" type="file" accept="image/png, image/jpg, image/jpeg, image/svg" name="{{ $name }}"
           wire:model.defer="{{ $name }}" class="hidden @if($validate) has-validation @endif"
           @change="$dispatch('upload')">

    @if($validate)
        @error($name) <span class="error">{{ $message }}</span> @enderror
    @endif
</div>
