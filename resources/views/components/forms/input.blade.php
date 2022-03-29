@php
    $inputClasses = 'form-control';
    if(in_array($type, ['checkbox', 'radio'])) {
        $inputClasses .=' me-2';
    }
    if($validate) {
        $inputClasses.= ' has-validation';
    }
@endphp

<div {{ $attributes->except(['x-model', 'disabled', 'readonly'])->merge(['class' => 'form-group']) }}>
    @if(!$placeholder)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <span class="input">
        @if($type == 'textarea')
            <textarea id="{{ $name }}" class="{{ $inputClasses }}" name="{{ $name }}" wire:model.defer="{{ $name }}"
                      @if($attributes->has('x-model')) x-model="{{ $attributes['x-model'] }}" @endif
                      @if($placeholder) placeholder="{{ $label }}" @endif></textarea>
        @else
            <input id="{{ $name }}" type="{{ $type }}" class="{{ $inputClasses }}" name="{{ $name }}"
                   @if($placeholder) placeholder="{{ $label }}" @endif
                   @if($value) value="{{ $value }}" @endif autofocus
                   @if($attributes->has('x-model')) x-model="{{ $attributes['x-model'] }}"
                   @endif  wire:model.defer="{{ $name }}" @if($attributes->has('disabled')) disabled="{{ $attributes['disabled'] }}"
                   @endif @if($attributes->has('readonly')) readonly="{{ $attributes['readonly'] }}"
                   @endif>
        @endif

        @if($validate)
            @error($name) <span class="error">{{ $message }}</span> @enderror
        @endif
    </span>
</div>
