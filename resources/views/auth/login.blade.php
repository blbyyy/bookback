<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>BOOKBACK</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link href="{{ asset('assets/img/bookback.png') }}" rel="icon">
  <link href="{{ asset('assets/img/bookback.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ secure_asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

  @if(session('register_success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('register_success') }}',
        showConfirmButton: false,
        timer: 2000
      });
    </script>
  @endif

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/bookback.png" alt="">
                  <span class="d-none d-lg-block">BOOKBACK</span>
                </a>
              </div>

              @if ($errors->has('email'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-1"></i>
                    {{ $errors->first('email') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <div class="card mb-3">

                  <div class="card-body">

                      <div class="pt-4 pb-2">
                          <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                          <p class="text-center small">Enter your username & password to login</p>
                      </div>

                      <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                          @csrf

                          <div class="col-12">
                              <label for="email" class="form-label">Email</label>
                              <div class="input-group has-validation">
                                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                                  <input type="text" name="email" class="form-control" id="email" required>
                                  <div class="invalid-feedback">Please enter your email.</div>
                              </div>
                          </div>

                          <div class="col-12">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" name="password" class="form-control" id="password" required>
                              <div class="invalid-feedback">Please enter your password!</div>
                          </div>

                          {{-- <div class="col-12">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                              </div>
                          </div> --}}

                          <div class="col-12">
                              <button class="btn btn-primary w-100" type="submit">Login</button>
                          </div>

                          <div class="col-12">
                              <p class="small mb-0">Don't have account? <a href="{{url('borrower/register-page')}}">Create an account</a></p>
                          </div>

                      </form>

                  </div>
              </div>

            </div>
          </div>
        </div>
      </section>

    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ secure_asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ secure_asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ secure_asset('js/custom.js')}}"></script>
  <script src="{{ secure_asset('assets/js/main.js')}}"></script>

</body>

</html>