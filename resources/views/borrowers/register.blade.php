<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>BOOKBACK Registration</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="{{ asset('assets/img/bookback.png') }}" rel="icon">
  <link href="{{ asset('assets/img/bookback.png') }}" rel="apple-touch-icon">

  <link href="{{ secure_asset('assets/img/bookback.png') }}" rel="icon">
  <link href="{{ secure_asset('assets/img/bookback.png') }}" rel="apple-touch-icon">

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

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                    <img src="{{asset('assets/img/bookback.png')}}" alt="">
                    <span class="d-none d-lg-block">BOOKBACK</span>
                    </a>
                </div>

                <div class="card mb-3">
                    <div class="card-body">

                        
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                            <p class="text-center small">Enter your personal details to create account</p>
                        </div>

                        <form class="row g-3 needs-validation" method="POST" action="{{route('borrower-registered')}}" novalidate>
                            @csrf

                            <div class="col-12">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                                <div class="invalid-feedback">Please, enter your name!</div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea type="text" name="address" class="form-control" id="address" style="height: 0px;" required></textarea>
                                <div class="invalid-feedback">Please, enter your address!</div>
                            </div>

                            <div class="col-4">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" name="birthdate" class="form-control" id="birthdate" required>
                                <div class="invalid-feedback">Please, enter your birthdate!</div>
                            </div>

                            <div class="col-4">
                                <label for="age" class="form-label">Age</label>
                                <input type="text" name="age" class="form-control" id="age" required>
                                <div class="invalid-feedback">Please, enter your age!</div>
                            </div>

                            <div class="col-4">
                                <label for="inputState" class="form-label">Sex</label>
                                <select id="sex" class="form-select" name="sex" required>
                                <option selected>Choose...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback">Please, enter your sex!</div>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" id="phone" required>
                                <div class="invalid-feedback">Please, enter your phone number!</div>
                            </div>

                            <div class="col-12">
                            <label for="yourEmail" class="form-label">Your Email</label>
                            <input type="email" name="email" class="form-control" id="yourEmail" placeholder="Please ensure this email address is valid and active for communication purposes." required>
                            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                            </div>

                            <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                            </div>

                            <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                            </div>

                            <div class="col-12">
                            <p class="small mb-0">Already have an account? <a href="{{url('/login')}}">Log in</a></p>
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

  <script src="{{ secure_asset('../assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ secure_asset('../assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ secure_asset('../js/custom.js')}}"></script>
  <script src="{{ secure_asset('../assets/js/main.js')}}"></script>

  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('js/custom.js')}}"></script>
  <script src="{{ asset('assets/js/main.js')}}"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>

</body>

</html>