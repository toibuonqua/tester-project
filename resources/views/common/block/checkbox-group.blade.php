<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label for="{{ $label }}" class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __('title.' . ($label ?? ($name ?? ''))) }}</label>
    <div class="{{ $inputClass ?? 'col-sm-3 btn-group' }}">
        @foreach ($options as $option)
            <input type="checkbox" class="btn-check" name="{{ $name }}[]" value="{{ $option }}" id="{{ $option }}" {{ in_array($option, $checked) ? 'checked':'' }}>
            <label class="btn btn-outline-primary" for="{{ $option }}">{{ $transform ? $transform[$option] : $option }}</label>
        @endforeach

    </div>
</div>