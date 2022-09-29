@extends('layout.master')
@section('title', 'Add department')
@section('nav-name-title', __('title.department-management'))

@section('content')

@include('common.block.title1', [$title = __('title.add-department')])

<form id="add_department" method="post" action="{{ route('department.store') }}">

    @csrf
    @method('POST')

    <div class="container">

        {{-- Department name --}}
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4">
                @error('name')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-2"><label>{{ __('title.department') }} * :</label></div>
            <div class="col-4"><input class="form-control" name="name" type="text"></div>
        </div>

    </div>

    <br><br>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('department.homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#myModal">{{ __('title.save') }}</button>
        </div>

    </div>

</form>

@include('common.modal.confirm_option', [
    $id_modal = 'myModal',
    $content = __('title.notice-add-department'),
    $id_form = "add_department",
    $name_but = __('title.add'),
])

<br>

@include('common.block.flash-message')

@endsection
