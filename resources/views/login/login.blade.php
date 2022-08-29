<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="js/func.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="{{ asset ('/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
</head>
<body>

    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center m-0" style="height: 80vh;">
          <div class="login_oueter">
            <div class="col-md-12 logo_outer">
              <img src="img/logo.png"/>
            </div>
            <form action="{{ route('auth.login') }}" method="post" id="login" autocomplete="off" class="bg-light border p-3">
              @csrf
              @method('POST')
              <div style="justify-content: center" class="form-row">

                <h4 class="title my-3">{{ __('title.login') }}</h4>
                <p>{{ __('title.text-under-login') }}</p>

                {{-- input email --}}
                <div class="col-12">
                  <div class="input-group mb-3">

                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>

                    <input name="email" type="text" value="" class="input form-control" id="email" placeholder="{{ __('title.email') }}" aria-label="Username" aria-describedby="basic-addon1" />

                  </div>
                </div>

                {{-- input mật khẩu --}}
                <div class="col-12">
                  <div class="input-group mb-3">

                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>

                    <input name="password" type="password" value="" class="input form-control" id="password" placeholder="{{ __('title.password') }}" required="true" aria-label="password" aria-describedby="basic-addon1" />

                    <div class="input-group-append">
                      <span class="input-group-text" onclick="password_show_hide();">
                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                        <i class="fas fa-eye" id="show_eye"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <div style="display: flex; justify-content: center" class="col-12">
                  <button style="width: 100%" class="btn btn-success" type="submit" name="signin">{{ __('title.login') }}</button>
                </div>

              </div>

            </form>
          </div>
        </div>
    </div>

</body>
</html>
