@extends('layout.master')
@section('title', 'Detail User')
@section('nav-name-title', __('title.user-management'))
@section('content')

@include('common.block.title1', [$title = __('title.detail-user')])

<br>

<div style="margin-left: 5%; display:flex">

    <div class="container">

        {{-- username --}}
        <div class="row">
            <div class="col-3"><label>{{ __('title.fullname') }} :</label></div>
            <div class="col-auto"><label>{{ $account->username }}</label></div>
        </div>

        <br><br>

        {{-- email --}}
        <div class="row">
            <div class="col-3"><label>{{ __('title.email') }} :</label></div>
            <div class="col-auto"><label>{{ $account->email }}</label></div>
        </div>

        <br><br>

        {{-- Phone number --}}
        <div class="row">
            <div class="col-3"><label>{{ __('title.phone-number') }} :</label></div>
            <div class="col-auto"><label>{{ $account->phone_number }}</label></div>
        </div>

    </div>

    <div class="container">

        {{-- Department --}}
        <div class="row">
            <div class="col-3"><label>{{ __('title.department') }} :</label></div>
            <div class="col-auto"><label>{{ $account->department->name }}</label></div>
        </div>

        <br><br>

        {{-- Role --}}
        <div class="row">
            <div class="col-3"><label>{{ __('title.role') }} :</label></div>
            <div class="col-auto"><label>{{ $account->role->name }}</label></div>
        </div>

        <br><br>

        {{-- Code user --}}
        <div class="row">
            <div class="col-3"><label>{{ __('title.code-user') }} :</label></div>
            <div class="col-auto"><label>{{ $account->code_user }}</label></div>
        </div>

    </div>

</div>

<br><br>

{{-- status --}}
<div style="margin-left: 6%" class="row">
    <div style="display: flex" class="col-md-6">
        <div class="col-2">
            <label>{{ __('title.status') }}:</label>
        </div>
        <div class="col-auto">
            <label style="margin-left: 20px" class="switch">
            @if ($account->status === 'active')
                <input name='status' type="checkbox" checked>
            @else
                <input name='status' type="checkbox">
            @endif
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>



<div class="display-but">

    <div style="margin-top: 50px">
        <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
    </div>

    <div style="margin-top: 50px">
        <button style="width: 180px" class="btn btn-outline-success" type="submit">{{ __('title.save') }}</button>
    </div>

</div>

@endsection
