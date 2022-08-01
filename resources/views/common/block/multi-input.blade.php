<div class="mb-3 row">
    <label class="{{ $label['class'] ?? 'col-sm-2 col-form-label' }}">{{ $label['name'] ? __('title.'.$label['name'] ) :'' }}</label>
    <div class="col" id="input-holder">

        <div class="row" id="inputDefault">
            <div class="col-sm-4">
                <input type="text" class="form-control mb-3 " name="{{ $name.'[]' }}">
            </div>
            <div class="col">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeInput(inputDefault)">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="offset-2">
        <span class="alert-danger mt-2">{{ $errors->first( $name.'.*') }}</span>
    </div>
    <div class="offset-2">
        <button type="button" id="add-tag" class="btn btn-primary btn-sm" onclick="addInput()">
            <i class="fas fa-plus"></i>
        </button>
    </div>
</div>


@once
    @push('script')
        <script>
            const inputName = '{{ $name }}';
        </script>
        <script src="{{ asset('js/multi-input.js') }}" type="text/javascript"></script>
    @endpush
@endonce
