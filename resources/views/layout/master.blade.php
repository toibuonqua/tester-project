<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebars.css">
</head>

<body>

    {{-- Thanh Menu --}}
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                {{-- <div class="container-fluid"> --}}
                <a href="#" class="navbar-brand">
                    <p class="text">@yield('nav-name-title')</p>
                </a>
                {{-- </div> --}}

                <div class="dropdown">
                    <img src="{{ asset('img/acc.jpg') }}" alt="" width="30" height="25"
                        class="d-inline-block align-text-top">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('title.account') }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('account.info') }}">{{ __('title.my-account') }}</a>
                        <a class="dropdown-item"
                            href="{{ route('account.changepw') }}">{{ __('title.change-password') }}</a>
                        <form action="{{ route('user.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">{{ __('title.logout') }}</button>
                        </form>
                    </div>
                </div>

            </div>
        </nav>
    </div>

    <div>
        <div class="split-block">

            {{-- Phần sidebars bên cạnh --}}
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height:1080px;">
                <ul class="nav nav-pills flex-column mb-auto">
                    @foreach (['Quản lý người dùng' => 'homepage', 'Quản lý khu làm việc' => 'worksm.homepage', 'Quản lý mặt hàng mới' => 'newam.homepage', 'Nhập hàng' => 'homepage', 'Danh sách đơn hàng' => 'homepage'] as $namepage => $link)
                        <li class="btn-toggle-nav">
                            <a href="{{ route($link) }}" class="nav-link link-dark">
                                {{ $namepage }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Nội dụng page --}}
            <div style="width: 100%">
                @yield('content')
            </div>
        </div>
    </div>

</body>

</html>
