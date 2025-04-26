@extends('layouts.navigation')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="/assets/img/bookback.png" rel="icon">
<link href="/assets/img/bookback.png" rel="apple-touch-icon">
<meta name="csrf-token" content="{{ csrf_token() }}">
<main id="main" class="main">

    <div class="pagetitle">
      <h1>My Profile</h1>
    </div>

    <section class="section profile">
        <div class="row">
          <div class="col-xl-4">
  
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
  
                        @if($librarian->avatar === 'avatar.jpg')
                          <div>
                            <img id="img" class="rounded-circle" src="https://cdn-icons-png.flaticon.com/512/219/219983.png" />
                          </div>
                        @else
                          <div>
                            <img id="img" class="rounded-circle" src="{{ asset('storage/avatars/'.$librarian->avatar) }}" />
                          </div>
                        @endif
                          <div class="col-sm-12 d-grid gap-2 mt-3" style="padding-bottom: 10px; padding-top: 20px">
                              <button id="toggleForm" type="submit" class="btn btn-outline-dark btn-sm">Change Avatar</button>
                          </div>
                        <form style="display: none;" id="avatarForm" class="row g-3" method="POST" action="{{route('librarian-change-avatar')}}" enctype="multipart/form-data">
                          @csrf
                          <div class="col-sm-12 gap-2">
                            <input class="form-control" type="file" id="avatar" name="avatar">
                          </div>
                          <div class="col-sm-12 d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-outline-dark btn-sm">Save Changes</button>
                          </div>
                        </form>                  
              
                <div class="text-center">
                  <h2>{{$librarian->name}}</h2>
                  <h3>{{$librarian->role}}</h3>
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
                        <div class="col-lg-9 col-md-8">{{$librarian->name}}</div>
                        </div>
                        
                        <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Email Address</div>
                        <div class="col-lg-9 col-md-8">{{$librarian->email}}</div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Address</div>
                        <div class="col-lg-9 col-md-8">{{$librarian->address}}</div>
                        </div>
    
                        <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Phone</div>
                        <div class="col-lg-9 col-md-8">{{$librarian->phone}}</div>
                        </div>
    
                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Birthdate</div>
                        <div class="col-lg-9 col-md-8">{{$librarian->birthdate}}</div>
                        </div>
    
                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Age</div>
                        <div class="col-lg-9 col-md-8">{{$librarian->age}}</div>
                        </div>
    
                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Sex</div>
                        <div class="col-lg-9 col-md-8">{{$librarian->sex}}</div>
                        </div>
    
                    </div>
  
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
    
                        <form method="POST" action="{{ route('librarian-update-profile', ['id' => $librarian->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="librarianName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianName" type="text" class="form-control" id="librarianName" value="{{$librarian->name}}">
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="librarianEmail" class="col-md-4 col-lg-3 col-form-label">Email Address</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianEmail" type="text" class="form-control" id="librarianEmail" value="{{$librarian->email}}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="librarianAddress" class="col-md-4 col-lg-3 col-form-label">Address</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianAddress" type="text" class="form-control" id="librarianAddress" value="{{$librarian->address}}">
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="librarianPhone" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianPhone" type="text" class="form-control" id="librarianPhone" value="{{$librarian->phone}}">
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="librarianBirthdate" class="col-md-4 col-lg-3 col-form-label">Birthdate</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianBirthdate" type="date" class="form-control" id="librarianBirthdate" value="{{$librarian->birthdate}}">
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="librarianAge" class="col-md-4 col-lg-3 col-form-label">Age</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianAge" type="text" class="form-control" id="librarianAge" value="{{$librarian->age}}">
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="librarianSex" class="col-md-4 col-lg-3 col-form-label">Sex</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="librarianSex" type="text" class="form-control" id="librarianSex" value="{{$librarian->sex}}">
                            </div>
                        </div>
    
                        <div class="col-sm-12 d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-outline-dark btn-sm">Save Changes</button>
                        </div>
                        </form>
    
                    </div>
    
                    <div class="tab-pane fade pt-3" id="profile-change-password">
                    <form id="passwordForm" action="{{ route('librarian-change-password') }}" method="post">
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

            $.ajax({
                url: "{{ route('librarian-validate-change-password') }}", // Use route helper
                method: 'POST',
                data: { 
                    password: enteredPassword, 
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                }, 
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
                    console.error(xhr.responseText); // Show detailed error
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