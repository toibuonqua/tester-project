@extends('layout.master')
@section('title', 'User Management')
@section('nav-name-title', __('title.account-info'))

@section('content')

<div style="max-width: 100%" class="container">

    <div class="display">
        <div class="row">
            <div style="display: flex" class="col-lg-6">
                <p class="text-des">{{ __('title.fullname') }}:</p>
                <p class="text-des">{{ $account->username }}</p>
            </div>
            <div class="col-lg-6">
                <p style="width: 100px">{{ __('title.department') }}:</p>
                <label>{{ $account->department->name }}</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">{{ __('title.email') }}:</div>
        <div class="col-lg-6">{{ $account->email }}</div>
        <div class="col-lg-6">{{ __('title.role') }}:</div>
        <div class="col-lg-6">{{ $account->role->name }}</div>
    </div>

    <div class="row">
        <div class="col-lg-6">{{ __('title.phone-number') }}:</div>
        <div class="col-lg-6">{{ $account->phone_number }}</div>
        <div class="col-lg-6">{{ __('title.code-user') }}:</div>
        <div class="col-lg-6">{{ $account->code_user }}</div>
    </div>

</div>

@endsection
