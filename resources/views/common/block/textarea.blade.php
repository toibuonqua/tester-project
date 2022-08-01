<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label for="{{ $name }}"
           class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __('title.' . ($label ?? ($name ?? ''))) }}</label>
    <div class="{{ $inputClass ?? 'col-sm-3' }}">
        <textarea cols="{{ $cols ?? 30 }}" rows="{{ $rows ?? 10 }}" type="{{ $type ?? 'text' }}"
                  class="form-control" id="{{ $name }}" name="{{ $name }}"
                  placeholder="{{ $placeholder ?? '' }}"
            {{ $attributes ?? '' }}>{{ $value ?? '' }}</textarea>
    </div>
</div>
