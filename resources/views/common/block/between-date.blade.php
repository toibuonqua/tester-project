<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label for="{{ $name }}"
        class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __('title.' . ($label ?? $name ?? '')) }}</label>
    <div class="{{ $inputClass ?? 'col-sm-6' }}">
        <div class="input-group mb-3">
            <span class="input-group-text">{{ __('title.from') }}</span>
            <input type="date" class="form-control" name="from" value="{{ $from ?? date('Y-m-d') }}">
            <span class="input-group-text">{{ __('title.to') }}</span>
            <input type="date" class="form-control" name="to" value="{{ $to ?? date('Y-m-d') }}">
        </div>
    </div>
</div>
