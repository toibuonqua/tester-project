<div class="row">
    <div class="col-3">
    <label for="{{ $name }}" class="col-form-label">{{ __("title.$name") }} * :</label>
    </div>
    <div class="col-5">
        <select name="{{ $name ?? 'course' }}" class="form-select course-select" id="{{ 'select_'.$name}}">
            <option value="">{{ __("title.select") . " " . __("title.$name") }}</option>
            @foreach ($options ?? [] as $option)
                <option value="{{ isset($valueField) ? $option->$valueField : $option }}" {{ ($select ?? old($name)) == (isset($valueField) ? $option->$valueField : $option) ? 'selected': '' }}>
                    {{ isset($displayField) ? $option->$displayField : $option }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- @include('common.block.select', [
        'name' => 'course',
        'options' => $courses ?? [],
        'valueField' => 'id',
        'displayField' => 'name',
        'select' =>  isset($classroom) && isset($classroom->course) ? $classroom->course->id : old('course')
    ]) --}}
