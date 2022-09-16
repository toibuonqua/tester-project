@extends('layout.master')
@section('title', 'Modify User')
@section('nav-name-title', __('title.user-management'))
@section('content')

@include('common.block.title1', [$title = __('title.modify-info-user')])


<form id="mod_user" method="post" action="{{ route('user.update', ['id' => $account->id]) }}">

    @csrf
    
    <div class="display-child-page">

        {{-- Field Họ và tên --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>Họ và tên:</label>
                </div>
                <div class="col-md-7">
                <input type="text" name="username" value="{{ $account->username }}" class="form-control">
                </div>
            </div>
        </div>

        {{-- Phòng ban --}}
        <div class="config-posi">
            @include('common.block.select', [
                'name' => 'department_id',
                'options' => $departments ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
                'select' => $account->department->id,
            ])
        </div>

    </div>

    <div class="display-child-page">

        {{-- Email --}}
        <div class="config-posi">
            <div style="margin-right: 40px" class="row">
                <div class="col-6 col-md-4">
                <label>Email:</label>
                </div>
                <div class="col-md-8">
                <label>{{ $account->email }}</label>
                </div>
            </div>
        </div>

        {{-- Chức danh --}}
        <div style="margin-top: 2.5%; margin-left:14%">
            @include('common.block.select', [
                'name' => 'role_id',
                'options' => $roles ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
                'select' => $account->role->id,
            ])
        </div>

    </div>

    <div class="display-child-page">

        {{-- SDT --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>SĐT:</label>
                </div>
                <div class="col-md-8">
                <input type="text" name="phone_number" value="{{ $account->phone_number }}" class="form-control">
                </div>
            </div>
        </div>

        {{-- Mã người dùng --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label class="col-form-label">Mã người dùng:</label>
                </div>
                <div class="col-md-6">
                <input type="text" name="code_user" value="{{ $account->code_user }}" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        <div style="justify-content: flex-start" class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Trạng thái:</label>
                </div>
                <div class="col-auto">

                  @if ($account->status === 'active')
                    <div class="form-check">
                        <input name='status' value="active" class="form-check-input" type="radio" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                        Hoạt động
                        </label>
                    </div>
                    <div class="form-check">
                        <input name='status' value="deactive" class="form-check-input" type="radio">
                        <label class="form-check-label" for="flexRadioDefault2">
                        Không hoạt động
                        </label>
                    </div>

                  @else
                    <div class="form-check">
                        <input name='status' value="active" class="form-check-input" type="radio">
                        <label class="form-check-label" for="flexRadioDefault1">
                        Hoạt động
                        </label>
                    </div>
                    <div class="form-check">
                        <input name='status' value="deactive" class="form-check-input" type="radio" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                        Không hoạt động
                        </label>
                    </div>

                  @endif
                </div>
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#myModal">{{ __('title.save') }}</button>
        </div>

    </div>

</form>

@include('common.modal.confirm_option', [
    $id_modal = "myModal",
    $content = __('title.notice-update-user'),
    $id_form = "mod_user",
    $name_but = __('title.modify'),
])

@endsection
