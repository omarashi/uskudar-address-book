<div {{ $attributes }}>
    <label
        for="{{ $name }}"
        class="flex items-center cursor-pointer"
    >
        <!-- toggle -->
        <div class="relative">
            <!-- input -->
            <input id="{{ $name }}" type="checkbox" class="sr-only" name="{{ $name }}" wire:model.defer="{{ $name }}" value="1" />
            <!-- line -->
            <div class="slide w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
            <!-- dot -->
            <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition border-gray-200 border-2"></div>
        </div>
        <!-- label -->
        <div class="ml-3 text-gray-700 font-medium">
            <h3 class="font-bold">{{ $label }}</h3>
        </div>
    </label>

</div>
