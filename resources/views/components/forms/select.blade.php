@php
    $inputClasses = 'form-control';
    if($validate) {
        $inputClasses.= ' has-validation';
    }
@endphp

<div {{ $attributes->except('x-model')->merge(['class' => 'form-group']) }}>
    <label for="{{ $name }}">{{ $label }}</label>
    <span class="input">
        <select id="{{ $name }}" class="{{ $inputClasses }}" name="{{ $name }}"
                wire:model.defer="{{ $name }}" @if($attributes->has('x-model')) x-model="{{ $attributes['x-model'] }}"
                @endif @if($attributes->has('disabled')) disabled="{{ $attributes['disabled'] }}"
                @endif @if($attributes->has('readonly')) readonly="{{ $attributes['readonly'] }}" @endif>
            <option value="" selected hidden>{{ $label }}</option>
            @foreach($options as $id => $option)
                <option value="{{ $id }}">{{ $option }}</option>
            @endforeach
        </select>

        @if($validate)
            @error($name) <span class="error">{{ $message }}</span> @enderror
        @endif
    </span>
</div>
