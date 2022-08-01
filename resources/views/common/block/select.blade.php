<div class="mb-3 row">
    <label for="{{ $name }}" class="col-sm-2 col-form-label">{{ __("title.$name") }}</label>
    <div class="col-sm-6">
        <select name="{{ $name ?? 'course' }}" class="form-select course-select" id="{{ 'select_'.$name}}">
            <option value="">{{ __("title.select") . " " . __("title.$name") }}</option>
            @foreach ($options ?? [] as $option)
                <option value="{{ isset($valueField) ? $option->$valueField : $option }}" {{ ($select ?? old($name)) == (isset($valueField) ? $option->$valueField : $option) ? 'selected': '' }}>
                    {{ isset($displayField) ? $option->$displayField : $option }}</option>
            @endforeach
        </select>
    </div>
</div>
