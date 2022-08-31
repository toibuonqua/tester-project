@extends('layout.master')
@section('title', 'User Management')
@section('nav-name-title', __('title.account-info'))

@section('content')

<div style="max-width: 100%, margin-left: 20%" class="container">

        <div class="row">
            <div style="display: flex" class="col-md-6">
                <p class="text-des">{{ __('title.fullname') }}:</p>
                <p style="margin-left: 5%" class="text-des">{{ $account->username }}</p>
            </div>
            <div style="display: flex" class="col-md-6">
                <p class="text-des">{{ __('title.department') }}:</p>
                <p style="margin-left: 5%" class="text-des">{{ $account->department->name }}</p>
            </div>
        </div>

        <div class="row">
            <div style="display: flex" class="col-md-6">
                <p class="text-des">{{ __('title.email') }}:</p>
                <p style="margin-left: 5%" class="text-des">{{ $account->email }}</p>
            </div>
            <div style="display: flex" class="col-md-6">
                <p class="text-des">{{ __('title.role') }}:</p>
                <p style="margin-left: 5%" class="text-des">{{ $account->role->name }}</p>
            </div>
        </div>

        <div class="row">
            <div style="display: flex" class="col-md-6">
                <p class="text-des">{{ __('title.phone-number') }}:</p>
                <p style="margin-left: 5%" class="text-des">{{ $account->phone_number }}</p>
            </div>
            <div style="display: flex" class="col-md-6">
                <p class="text-des">{{ __('title.code-user') }}:</p>
                <p style="margin-left: 5%" class="text-des">{{ $account->code_user }}</p>
            </div>
        </div>

</div>

@endsection
