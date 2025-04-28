<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>BOOKBACK</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/bookback.png') }}" rel="icon">
  <link href="{{ asset('assets/img/bookback.png') }}" rel="apple-touch-icon">
  {{-- <link href="{{ secure_asset('assets/img/bookback.png') }}" rel="icon">
  <link href="{{ secure_asset('assets/img/bookback.png') }}" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
    {{-- <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"> --}}
    

    <link href="{{ secure_asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/style.css') }}" rel="stylesheet">
    
    <!-- Corrected Favicon Link -->
    {{-- <link rel="icon" href="{{ secure_asset('assets/img/favicon.png') }}" type="image/png">     --}}

  <!-- Template Main CSS File -->
    

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      @auth
        @if (Auth::user()->role === 'Borrower')
          <a href="{{ url('/book-list') }}" class="logo d-flex align-items-center">
              <img src="{{asset('assets/img/bookback.png')}}" alt="" style="padding-right: 5px;">
              <span class="d-none d-lg-block">BOOKBACK</span>
          </a>
        @elseif (Auth::user()->role === 'Librarian')
          <a href="{{ url('/admin/dashboard') }}" class="logo d-flex align-items-center">
              <img src="{{asset('assets/img/bookback.png')}}" alt="" style="padding-right: 5px;">
              <span class="d-none d-lg-block">BOOKBACK</span>
          </a>
        @endif
      @else
          <a href="{{ url('/login') }}" class="logo d-flex align-items-center">
              <img src="{{asset('assets/img/bookback.png')}}" alt="" style="padding-right: 5px;">
              <span class="d-none d-lg-block">Login to BOOKBACK</span>
          </a>
      @endauth
      <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>
  

    @auth
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon notificationBell" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell" style="font-size: 25px;" ></i>
            @if (Auth::user()->role === 'Librarian')
              @if ($adminNotifCount > 0)
                <span class="badge bg-primary badge-number">{{$adminNotifCount}}</span>
              @endif
            @elseif (Auth::user()->role === 'Borrower')
              @if ($borrowerNotifCount > 0)
                <span class="badge bg-primary badge-number">{{$borrowerNotifCount}}</span>
              @endif
            @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="width: 350px">
            
            <li class="dropdown-header">
              <div class="text-center" style="font-size: large">
                <strong>Notifications</strong>
                <i class="bx bxs-bell-ring"></i>
              </div>                            
            </li>        

            <li>
              <hr class="dropdown-divider">
            </li>

            @if (Auth::user()->role === 'Librarian')
              @foreach ($adminNotification as $notif)
                <li class="notification-item">
                  <i class="bi bi-info-circle text-primary"></i>
                  <div>
                    <h4>{{$notif->title}}</h4>
                    <p>{{$notif->message}}</p>
                    <p>{{ \Carbon\Carbon::parse($notif->date)->diffForHumans() }}</p>
                  </div>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              @endforeach
            @elseif (Auth::user()->role === 'Borrower')
              @foreach ($borrowerNotification as $notif)
                  <li class="notification-item">
                    <i class="bi bi-info-circle text-primary"></i>
                    <div>
                      <h4>{{$notif->title}}</h4>
                      <p>{{$notif->message}}</p>
                      <p>{{ \Carbon\Carbon::parse($notif->date)->diffForHumans() }}</p>
                    </div>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
              @endforeach
            @endif

            <li class="dropdown-footer">
              @if (Auth::user()->role === 'Librarian')
                <a href="{{url('/admin/all-notifications')}}" class="text-decoration-none">
                  <div class="d-grid gap-2 mt-3">
                      <button class="btn btn-outline-primary btn-sm" type="button">View all notifications</button>
                  </div>
                </a>
              @elseif (Auth::user()->role === 'Borrower')
                <a href="{{url('/all-notifications')}}" class="text-decoration-none">
                  <div class="d-grid gap-2 mt-3">
                      <button class="btn btn-outline-primary btn-sm" type="button">View all notifications</button>
                  </div>
                </a>
              @endif
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @if(Auth::user()->role === 'Borrower')
              @if($borrowers->avatar === 'avatar.jpg')
                <img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2"></span>
              @else
                <img src="{{ asset('storage/avatars/'.$borrowers->avatar) }}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2"></span>
              @endif
            @else
              @if($librarian->avatar === 'avatar.jpg')
                <img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2"></span>
              @else
              <img src="{{ asset('storage/avatars/'.$librarian->avatar) }}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2"></span>
              @endif
            @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->role }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              @if(Auth::user()->role == 'Borrower') 
                <a class="dropdown-item d-flex align-items-center" href="{{url('/borrower/profile/{id')}}">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              @endif
              @if(Auth::user()->role == 'Librarian') 
                <a class="dropdown-item d-flex align-items-center" href="{{url('/admin/profile/{id')}}">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              @endif
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" 
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
              </a>
              <form id="logout-form" action="{{ url('/signout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </li>
          

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        
      </ul>
    </nav><!-- End Icons Navigation -->
    @endauth

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
    @auth
    <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

        @if(Auth::user()->role === 'Librarian')
        <li class="nav-item">
          <a class="nav-link " href="{{url('/admin/dashboard')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bx bxs-user-detail"></i></i><span>User List</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{url('/admin/borrower-list')}}">
                <i class="bi bi-circle"></i><span>Barrowers</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/librarian-list')}}">
                <i class="bi bi-circle"></i><span>Librarians</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{url('/admin/book-catalog')}}">
            <i class="bi bi-book-half"></i>
            <span>Books</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{url('/admin/book-rentals')}}">
            <i class="bx bxs-book-bookmark"></i>
            <span>Book Rentals</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{url('/admin/borrowing-log')}}">
            <i class="bi bi-journal-text"></i>
            <span>Borrowing Log</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{url('/admin/reminder')}}">
            <i class="bx bx-list-ul"></i>
            <span>Book Rental Tracker</span>
          </a>
        </li>
        @elseif(Auth::user()->role === 'Borrower')
        <li class="nav-item">
          <a class="nav-link " href="{{url('/book-list')}}">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{url('/my-history')}}">
            <i class="ri-history-line"></i>
            <span>My History</span>
          </a>
        </li>
        @endif

      </ul>

    </aside><!-- End Sidebar-->
    @endauth

  <main id="main" class="main">

  </main>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  {{-- <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('assets/js/main.js')}}"></script>
  <script src="{{ asset('js/custom.js')}}"></script> --}}

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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>

  <!-- Template Main JS File -->

</body>

</html>