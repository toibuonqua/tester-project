<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <!-- Bootstrap core CSS-->
    @section('static')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
        {{-- <script src="/js/user.js"></script> --}}
        <script src="{{ asset('js/flash-message-remove.js') }}"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    @show
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Codestar Training</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                @include('common.block.active-nav', ['itemList' => [
                'exam' => 'user.list-exam',
                'exam-result' => 'user.exam-result',
                'practice' => 'practice'
                ]])


                <a href="{{ route('user.statistic') }}" class="btn btn-outline-success" style="margin-right: 1rem">{{ __('title.statistic') }}</a>

                <form class="d-flex" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a href="{{ route('account.edit-password') }}" class="btn btn-outline-success" style="margin-right: 1rem">{{ __('title.change-password') }}</a>
                    <button class="btn btn-outline-success ml-2" type="submit">{{ __('title.logout') }}</button>
                </form>
            </div>
        </div>
    </nav>

    @if ($message ?? '')
        <div class="alert alert-{{ $messageType ?? 'info' }}" role="alert">
            {{ $message ?? '' }}
        </div>
    @endif

    <div class="container white-box">
        <div class="row mb-3">
            <div class="col-sm-12">

                @section('page')
                    <div>
                        Please declare section('page') here
                    </div>
                @show

            </div>
        </div>
    </div>

    @stack('script')
</body>

</html>
