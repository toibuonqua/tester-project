<div class="mb-3 row" id="{{ isset($courseId) ? 'course_'.$courseId : 'course_'.now()->getTimestamp() }}">
    <label class="{{ $label['class'] ?? 'col-sm-2 col-form-label' }}">{{ $label['name'] ? __('title.'.$label['name'] ) :'' }}</label>
    <div class="col" id="input-holder">

    </div>
    <div class="offset-2">
        <button type="button" id="add-tag" class="btn btn-primary btn-sm" onclick="addInput()">
            <i class="fas fa-plus"></i>
        </button>
    </div>
</div>


@once
    @push('script')
        <script src="{{ asset('js/render-element.js') }}" type="text/javascript"></script>
        <script>
            const inputName = '{{ $name ?? 'course' }}';
            const labelName = '{{ __("title.select") . " " . __("title.".$label['name']) }}';
            const optionList =  {{ Illuminate\Support\Js::from($options ?? []) }};
            const optionQuantity =  {{ Illuminate\Support\Js::from($optionQuantity ?? []) }};
            const displayField  = '{{ $displayField ?? 'name' }}';
            const valueField = '{{ $valueField ?? 'id' }}';
            const quantity = '{{ $quantity ?? 'quantity'  }}';
            let courseId = {{ $courseId ?? 0 }};

            const getTemplate = (selectId) =>{
                let options = optionList.reduce((last,option)=>{
                    if (optionQuantity.length > 0){
                        let optionQ = optionQuantity.find(e=> e.category_id == option.id && e.course_id ==  courseId);
                        if (optionQ){
                            return last += `<option value="${valueField ? option[valueField] : option}" >${ displayField ? option[displayField] : option} : ${ optionQ.quantity }</option>`
                        }
                        return last;

                    }else{
                        return last += `<option value="${valueField ? option[valueField] : option}" >${ displayField ? option[displayField] : option} </option>`;
                    }
                },'')
                return `
                <div class="row mb-2" id="${selectId}">
                    <div class="col-sm-4">
                        <select name="${inputName + selectId}[]" class="form-select course-select" multiple="multiple">
                            ${options}
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-control mb-3 " min="1"  placeholder="{{ __('title.quantity') }}" name="${quantity}[]">
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeInput(${selectId})">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <input name="selectNames[]" value="${inputName + selectId}" type="hidden">
                </div>
                `;
            }

            const removeInput = (ele) => {
                ele.remove();
            }


            const addInput = () => {
                let selectId = `select${new Date().getTime()}`;
                document.querySelector('#input-holder').append(stringToHTML(getTemplate(selectId)));
                $(`#${selectId} select`).select2();
            }

        </script>
    @endpush
@endonce
