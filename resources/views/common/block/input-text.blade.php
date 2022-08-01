<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label for="{{ $name }}"
        class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __('title.' . ($label ?? ($name ?? ''))) }}</label>
    <div class="{{ $inputClass ?? 'col-sm-3' }}">
        <input type="{{ $type ?? 'text' }}" class="form-control" id="{{ $name }}" name="{{ $name }}"
            value="{{ $value ?? old($name,'') }}" placeholder="{{ $placeholder ?? '' }}" {{ ($readonly ?? false) ? 'readonly' : '' }}>
        @error($name)
            <div class="mt-3">
                <span class="alert-danger mt-2">{{ $errors->first($name) }}</span>
            </div>
        @enderror
    </div>

</div>
