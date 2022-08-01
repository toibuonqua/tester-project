<div class="mb-3 row">
    <label for="{{ $name }}" class="col-sm-2 col-form-label">{{ __("title.$name") }}</label>
    <div class="col-sm-6">
        <select name="{{ $name ?? 'course' }}[]" class="form-select course-select {{ $name }}" multiple="multiple">
            <option value="" disabled>{{ __("title.select") . " " . __("title.$name") }}</option>
            @foreach ($options as $option)
                <option
                    value="{{ isset($valueField) ? $option->$valueField : $option }}" {{ in_array( (isset($valueField) ? $option->$valueField : $option) , ($select ?? old($name,[])))  ? 'selected="selected"': ''   }}>
                    {{ isset($displayField) ? $option->$displayField : $option }}</option>
            @endforeach
        </select>
    </div>
</div>


@push('script')

    <script>
        $(document).ready(function () {
            $(".{{ $name }}").select2();
        });
    </script>

@endpush


