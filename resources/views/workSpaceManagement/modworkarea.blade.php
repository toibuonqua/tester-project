@extends('layout.master')
@section('title', __('title.modify-work-area'))
@section('nav-name-title', __('title.work-management'))
@section('content')

    @include('common.block.title1')


<form id="mod_workarea" method="post" action="{{ route('worksm.update', ['id' => $workarea->id]) }}">

    @csrf

    <div class="display-child-page">

        {{-- Mã KVLV --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label>{{ __('title.code-work-area') }} * :</label>
                </div>
                <div class="col-md-8">
                <input type="text" value="{{ $workarea->work_areas_code }}" name="work_areas_code" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="display-child-page">

        {{-- Tên KVLV --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label>{{ __('title.name-work-area') }} * :</label>
                </div>
                <div class="col-md-8">
                <input type="text" value="{{ $workarea->name }}" name="name" class="form-control">
                </div>
            </div>
        </div>
    </div>


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
    $content = __('title.notice-update-work-area'),
    $id_form = 'mod_workarea',
    $name_but = __('title.modify'),
])

@endsection
