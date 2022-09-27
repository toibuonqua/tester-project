@extends('layout.master')
@section('title', __('title.add-work-area'))
@section('nav-name-title', __('title.work-management'))
@section('content')

@include('common.block.title1')

<form id="add_workarea" method="post" action="{{ route('worksm.store') }}">

    @csrf
    @method('POST')

    <br>

    <div class="container">

        {{-- Mã KVLV --}}
        <div class="row">

            <div class="col-2">
                <label>{{ __('title.code-work-area') }} * :</label>
            </div>

            <div class="col-3">
                <input maxlength="6" type="text" name="work_areas_code" class="form-control">
            </div>

            <div class="col-auto">
                <p data-bs-toggle="tooltip" data-bs-placement="right" title="
                    - Linmit 1 - 100 characters.
                    - Only accept numbers and letters in input
                    - Not allow white space, symbols and non letter in put">
                    <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                </p>
            </div>

        </div>

        <br><br>

        {{-- Tên KVLV --}}
        <div class="row">

            <div class="col-2">
                <label>{{ __('title.name-work-area') }} * :</label>
            </div>

            <div class="col-3">
                <input maxlength="6" type="text" name="name" class="form-control">
            </div>

            <div class="col-auto">
                <p data-bs-toggle="tooltip" data-bs-placement="right" title="
                    - Linmit 1 - 100 characters.
                    - Only accept numbers and letters in input
                    - Not allow white space, symbols and non letter in put">
                    <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                </p>
            </div>

        </div>

    </div>

    <br><br>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('worksm.homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#myModal">{{ __('title.save') }}</button>
        </div>

    </div>

</form>

@include('common.modal.confirm_option', [
    $id_modal = 'myModal',
    $content = __('title.notice-add-work-area'),
    $id_form = "add_workarea",
    $name_but = __('title.add'),
])

<br>

@include('common.block.flash-message')

@endsection
