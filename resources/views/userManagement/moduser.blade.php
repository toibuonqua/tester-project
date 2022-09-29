@extends('layout.master')
@section('title', 'Modify User')
@section('nav-name-title', __('title.user-management'))
@section('content')

@include('common.block.title1', [$title = __('title.modify-info-user')])

<form id="mod_user" method="post" action="{{ route('user.update', ['id' => $account->id]) }}">

    @csrf

    <br>

    <div style="margin-left: 5%; display:flex">

        <div class="container">

            {{-- username --}}
            <div class="row">
                <div class="col-3"><label>{{ __('title.fullname') }} * :</label></div>
                <div class="col-5"><input maxlength="100" class="form-control" name="username" value="{{ $account->username }}" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right"
                        title="- Maxlength là 100 ký tự
- Chỉ chấp nhận kí tự số và chữ cái
- Không được phép nhập các ký tự đặc biệt">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

            <br><br>

            {{-- email --}}
            <div class="row">
                <div class="col-3"><label>{{ __('title.email') }} * :</label></div>
                <div class="col-5"><input maxlength="200" class="form-control" name="email" value="{{ $account->email }}" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right"
                        title="- Maxlength là 200 ký tự
- Chỉ chấp nhận kí tự số và chữ cái
- Chỉ chấp nhận kí tự (-),(_),(.),(@)
- Không được phép nhập các kí tự trắng">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

            <br><br>

            {{-- Phone number --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5"></div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.phone-number') }} * :</label></div>
                <div class="col-1"><input class="form-control" style="width: 70px" type="text" disabled="disabled" value="+84"></div>
                <div class="col-4"><input maxlength="30" class="form-control" name="phone_number" value="{{ $account->phone_number }}" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right"
                        title="- Maxlength is 15 numbers
- Only accept numbers.
- Not allow symbols, white space and non letter in input.">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

            <br><br>

            {{-- status --}}
            <div class="row">

                <div class="col-3">
                    <label>{{ __('title.status') }} * :</label>
                </div>
                <div class="col-3">
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

        <div class="container">

            {{-- Department --}}
            @include('common.block.select', [
                'name' => 'department_id',
                'options' => $departments ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
                'display' => 'block',
                'select' => $account->department->id,
            ])

            <br><br>

            {{-- Role --}}
            @include('common.block.select', [
                'name' => 'role_id',
                'options' => $roles ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
                'display' => 'block',
                'select' => $account->role->id,
            ])

            <br><br>

            {{-- Workarea --}}
            @include('common.block.select', [
                'name' => 'workarea_id',
                'options' => $workareas ?? [],
                'valueField' => 'id',
                'displayField' => 'work_areas_code',
                'display' => 'block',
                'select' => $account->workarea->id,
            ])

            <br><br>

            {{-- Code user --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5"></div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.code-user') }} * :</label></div>
                <div class="col-5"><input maxlength="10" class="form-control" name="code_user" value="{{ $account->code_user }}" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right"
                        title="- Maxlength là 10 kí tự.
- Chỉ chấp nhận ký tự số.
- Không được phép nhập các ký tự trắng, ký tự đặc biệt và chữ cái">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

        </div>

    </div>

    <br>

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
