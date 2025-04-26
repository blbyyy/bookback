@extends('layouts.navigation')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="/assets/img/bookback.png" rel="icon">
<link href="/assets/img/bookback.png" rel="apple-touch-icon">
<main id="main" class="main">

    @if(session('success'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: '{{ session('success') }}',
          showConfirmButton: false,
          timer: 2000
        });
      </script>
    @endif

    <div class="pagetitle">
      <h1>My Profile</h1>
    </div>

    <section class="section profile">
        <div class="row">
          <div class="col-xl-4">
  
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
  
                        @if($borrowers->avatar === 'avatar.jpg')
                          <div>
                            <img id="img" class="rounded-circle" src="https://cdn-icons-png.flaticon.com/512/219/219983.png" />
                          </div>
                        @else
                          <div>
                            <img id="img" class="rounded-circle" src="{{ asset('storage/avatars/'.$borrowers->avatar) }}" />
                          </div>
                        @endif
                          <div class="col-sm-12 d-grid gap-2 mt-3" style="padding-bottom: 10px; padding-top: 20px">
                              <button id="toggleForm" type="submit" class="btn btn-outline-dark btn-sm">Change Avatar</button>
                          </div>
                        <form style="display: none;" id="avatarForm" class="row g-3" method="POST" action="{{route('borrower-change-avatar')}}" enctype="multipart/form-data">
                          @csrf
                          <div class="col-sm-12 gap-2">
                            <input class="form-control" type="file" id="avatar" name="avatar">
                          </div>
                          <div class="col-sm-12 d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-outline-dark btn-sm">Save Changes</button>
                          </div>
                        </form>                  
              
                <div class="text-center">
                  <h2>{{$borrowers->name}}</h2>
                  <h3>{{$borrowers->role}}</h3>
                </div>
                
              </div>
            </div>
  
          </div>
  
          <div class="col-xl-8">
  
            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
  
                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>
  
                  <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                  </li>
  
                  <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                  </li>
  
                </ul>

                <div class="tab-content pt-2">
  
                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
      
                    <h5 class="card-title">Profile Details</h5>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->name}}</div>
                    </div>
                    
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Email Address</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->email}}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Address</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->address}}</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Phone</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->phone}}</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Birthdate</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->birthdate}}</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Age</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->age}}</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Sex</div>
                      <div class="col-lg-9 col-md-8">{{$borrowers->sex}}</div>
                    </div>
  
                  </div>
  
                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <form method="POST" action="{{ route('borrower-update-profile', ['id' => $borrowers->id]) }}" enctype="multipart/form-data">
                      @csrf
                      <div class="row mb-3">
                        <label for="borrowerName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerName" type="text" class="form-control" id="borrowerName" value="{{$borrowers->name}}">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="borrowerEmail" class="col-md-4 col-lg-3 col-form-label">Email Address</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerEmail" type="text" class="form-control" id="borrowerEmail" value="{{$borrowers->email}}" disabled>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="borrowerAddress" class="col-md-4 col-lg-3 col-form-label">Address</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerAddress" type="text" class="form-control" id="borrowerAddress" value="{{$borrowers->address}}">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="borrowerPhone" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerPhone" type="text" class="form-control" id="borrowerPhone" value="{{$borrowers->phone}}">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="borrowerBirthdate" class="col-md-4 col-lg-3 col-form-label">Birthdate</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerBirthdate" type="date" class="form-control" id="borrowerBirthdate" value="{{$borrowers->birthdate}}">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="borrowerAge" class="col-md-4 col-lg-3 col-form-label">Age</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerAge" type="text" class="form-control" id="borrowerAge" value="{{$borrowers->age}}">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="borrowerSex" class="col-md-4 col-lg-3 col-form-label">Sex</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="borrowerSex" type="text" class="form-control" id="borrowerSex" value="{{$borrowers->sex}}">
                        </div>
                      </div>
  
                      <div class="col-sm-12 d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-outline-dark btn-sm">Save Changes</button>
                      </div>
                    </form>
  
                  </div>
  
                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <form id="passwordForm" action="{{ route('borrower-change-password') }}" method="post">
                        @csrf
  
                        <div class="row mb-3">
                          <label for="password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="password" type="password" class="form-control" id="password" required onchange="validatePassword()">
                              <span id="passwordMatchMessages"></span>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                          <label for="newpassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="newpassword" type="password" class="form-control" id="newpassword" required>
                          </div>
                        </div>
                      
                        <div class="row mb-3">
                            <label for="renewpassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="renewpassword" type="password" class="form-control" id="renewpassword" required>
                                <span id="passwordMatchMessage"></span>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-dark changePassword">Change Password</button>
                            <button style="display: none;" type="button" class="btn btn-outline-dark errorButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Please double-check your password entry.">
                              Change Password
                            </button>
                        </div>
                        
                    </form>
                  </div>
  
                </div>
  
              </div>
            </div>
  
          </div>
        </div>
    </section>

</main>
<script>
  function validatePassword() {
    var enteredPassword = document.getElementById('password').value;
    var messageSpan = $("#passwordMatchMessages");

    // Send the hashed password to the server for validation
    $.ajax({
        url: '/borrower/profile/validate-password',
        method: 'POST',
        data: { password: enteredPassword }, // Use 'password' as the key to match your Laravel controller
        success: function(response) {
            if (response.match) {
                messageSpan.text("Current password match.");
                messageSpan.css('color', 'green');
                $(".changePassword").show();
                $(".errorButton").hide();
            } else {
                messageSpan.text("Current password is wrong");
                messageSpan.css('color', 'red');
                $(".changePassword").hide();
                $(".errorButton").show();
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Handle error if needed
        }
    });

  }

  $(document).ready(function () {

        $("#toggleForm").click(function () {
            $("#avatarForm").toggle();
        });

    let img = document.getElementById('img');
    let input = document.getElementById('avatar');

    input.onchange = (e) => {
      if (input.files[0])
      img.src = URL.createObjectURL(input.files[0])
    }

    $('#newpassword, #renewpassword').on('input', function () {
                  var newPassword = $("#newpassword").val();
                  var renewPassword = $("#renewpassword").val();
                  var currentPassword = $("#password").val();
                  var messageSpan = $("#passwordMatchMessage");

                  if ((!newPassword && !renewPassword) || !currentPassword) {
                      messageSpan.text("You need to enter your current password.");
                      messageSpan.css('color', 'orange');
                      $(".changePassword").prop("disabled", true);
                      $(".errorButton").hide();
                  } else if (newPassword !== renewPassword) {
                      messageSpan.text("Password did not match.");
                      messageSpan.css('color', 'red');
                      $(".changePassword").hide();
                      $(".errorButton").show();
                  } else if (newPassword === renewPassword) {
                      messageSpan.text("Password match.");
                      messageSpan.css('color', 'green');
                      $(".changePassword").show();
                      $(".changePassword").prop("disabled", false);
                      $(".errorButton").hide();
                  }
    });

  });
</script>