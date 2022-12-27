@extends('layout.master')
@section('title', __('title.modify-work-area'))
@section('nav-name-title', __('title.work-management'))
@section('content')

@include('common.block.title1')


<form id="mod_workarea" method="post" action="{{ route('worksm.update', ['id' => $workarea->id]) }}">

    @csrf
    @method('POST')

    <br>

    <div class="container">

        {{-- Mã KVLV --}}
        <div class="row">
            <div class="col-2"></div>
            <div class="col-3">
                @error('work_areas_code')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">

            <div class="col-2">
                <label>{{ __('title.code-work-area') }} * :</label>
            </div>

            <div class="col-3">
                <input type="text" maxlength="100" name="work_areas_code" value="{{ $workarea->work_areas_code }}" class="form-control">
            </div>

            <div class="col-auto">
                <p data-bs-toggle="tooltip" data-bs-placement="right" title="
- Limit 1 - 100 characters.
- Only accept numbers and letters in input
- Not allow white space, symbols and non letter in put">
                    <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                </p>
            </div>

        </div>
        <div class="row">
            <div class="col-2"></div>
            <div id="workarea_validate" class="col-3 text-error"></div>
        </div>

        <br><br>

        {{-- Tên KVLV --}}
        <div class="row">
            <div class="col-2"></div>
            <div class="col-3">
                @error('name')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">

            <div class="col-2">
                <label>{{ __('title.name-work-area') }} * :</label>
            </div>

            <div class="col-3">
                <input type="text" maxlength="100" name="name" value="{{ $workarea->name }}"  class="form-control">
            </div>

            <div class="col-auto">
                <p data-bs-toggle="tooltip" data-bs-placement="right" title="
- Linmit 1 - 100 characters.
- Only accept numbers and letters in input
- Not allow symbols and non letter in input">
                    <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                </p>
            </div>

        </div>
        <div class="row">
            <div class="col-2"></div>
            <div id="name_validate" class="col-3 text-error"></div>
        </div>

    </div>

    <br><br>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('worksm.homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" type="button" onclick="submit_modify_workarea()">{{ __('title.save') }}</button>
        </div>

    </div>

    {{-- button submit --}}
    <input id="submitModifyWorkarea" style="display: none" type="button" data-bs-toggle="modal" data-bs-target="#myModal">


</form>

@include('common.modal.confirm_option', [
    $id_modal = 'myModal',
    $content = __('title.notice-update-work-area'),
    $id_form = 'mod_workarea',
    $name_but = __('title.modify'),
])

@endsection
