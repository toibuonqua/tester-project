<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebars.css">
</head>
<body>

    {{-- Thanh Menu --}}
    <div>
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1"><p class="text">{{ $NavName }}</p></span>
            </div>
        </nav>
    </div>

    <div>
        <div class="split-block">

            {{-- <div class="box">
            @foreach ($list as $item)
                <div>
                    <button class="but"><a class="text" href="/user-management">{{ $item }}</a></button>
                </div>
            @endforeach
            </div> --}}

            {{-- Phần sidebars bên cạnh --}}
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height:1080px;">
                <ul class="nav nav-pills flex-column mb-auto">

                  <li class="btn-toggle-nav">
                    <a href="{{ route('honepage') }}" class="nav-link link-dark">
                        Quản lý người dùng
                    </a>
                  </li>

                  <li class="btn-toggle-nav">
                    <a href="{{ route('WorkSM') }}" class="nav-link link-dark">
                        Quản lý khu làm việc
                    </a>
                  </li>

                  <li class="btn-toggle-nav">
                    <a href="{{ route('NewAM') }}" class="nav-link link-dark">
                        Quản lý hàng mới về
                    </a>
                  </li>

                  <li class="btn-toggle-nav">
                    <a href="/" class="nav-link link-dark">
                        Nhập hàng
                    </a>
                  </li>

                  <li class="btn-toggle-nav">
                    <a href="/" class="nav-link link-dark">
                      Danh sách đơn hàng
                    </a>
                  </li>

                </ul>
            </div>

            {{-- Nội dụng page --}}
            <div>
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
