@extends('layout.master')
@section('title', 'Detail User')
@section('nav-name-title', __('title.user-management'))
@section('content')

@include('common.block.title1', [$title = __('title.detail-user')])

<div style="max-width: 100%, margin-left: 20%" class="container">

    {{-- Field họ tên và phòng ban --}}
    <div class="row">
        <div style="display: flex" class="col-md-6">
            <p>{{ __('title.fullname') }}:</p>
            <p style="margin-left: 5%">{{ $account->username }}</p>
        </div>
        <div style="display: flex" class="col-md-6">
            <p>{{ __('title.department') }}:</p>
            <p style="margin-left: 5%">{{ $account->department->name }}</p>
        </div>
    </div>

    <div class="row">
        <div style="display: flex" class="col-md-6">
            <p>{{ __('title.email') }}:</p>
            <p style="margin-left: 5%">{{ $account->email }}</p>
        </div>
        <div style="display: flex" class="col-md-6">
            <p>{{ __('title.role') }}:</p>
            <p style="margin-left: 5%">{{ $account->role->name }}</p>
        </div>
    </div>

    <div class="row">
        <div style="display: flex" class="col-md-6">
            <p>{{ __('title.phone-number') }}:</p>
            <p style="margin-left: 5%">{{ $account->phone_number }}</p>
        </div>
        <div style="display: flex" class="col-md-6">
            <p>{{ __('title.code-user') }}:</p>
            <p style="margin-left: 5%">{{ $account->code_user }}</p>
        </div>
    </div>

    <div class="row">
        <div style="display: flex" class="col-md-6">
            <div class="col-auto">
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
