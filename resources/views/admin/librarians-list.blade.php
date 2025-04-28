@extends('layouts.navigation')
<link href="{{ asset('assets/img/bookback.png') }}" rel="icon">
<link href="{{ asset('assets/img/bookback.png') }}" rel="apple-touch-icon">
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Librarian User List</h1>
    </div>
      
      <form method="GET" action="{{ route('librarian-list.page') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search Name">
        <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
      </form>
  
      <div id="addLibrarianForm" class="col-md-12" style="display: none;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Librarian User</h5>
                  <form class="row g-3" method="POST" action="{{route('librarian-added')}}" enctype="multipart/form-data">
                    @csrf
    
                    <div class="col-md-12">
                      <div class="form-floating">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required>
                        <label for="name">Full Name</label>
                      </div>
                    </div>
    
                    <div class="col-12">
                        <div class="form-floating">
                          <textarea name="address" class="form-control" placeholder="Address" id="address" style="height: 100px;" required></textarea>
                          <label for="address">Address</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="date" name="birthdate" class="form-control" id="birthdate" placeholder="Birthdate" required>
                        <label for="birthdate">Birthdate</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" name="age" class="form-control" id="age" placeholder="Age" required>
                        <label for="age">Age</label>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="sex" name="sex" aria-label="State" required>
                          <option selected>---SELECT SEX---</option>
                          <option value="Male">MALE</option>
                          <option value="Female">FEMALE</option>
                        </select>
                        <label for="sex"s>Sex</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Pnone" required>
                        <label for="phone">Pnone</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email Address" required>
                        <label for="email">Email Address</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                        <label for="password">Password</label>
                      </div>
                    </div>

                    <div class="col-12" >
                      <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-outline-dark">Create</button>
                          <button type="reset" class="btn btn-outline-dark ms-2" onclick="toggleAddLibrarian()">Close</button>
                      </div>
                    </div>
  
                  </form>
            </div>
        </div>
      </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">LIST OF ALL LIBRARIAN USER</h5>

              <div class="d-grid gap-2 mt-3" style="padding-bottom: 20px">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleAddLibrarian()"><i class="ri-user-add-line"></i> ADD LIBRARIAN</button>
              </div>

              @if ($librarian_user->isNotEmpty())
                <table class="table table-hover">
                  <thead>
                    <tr class="text-center">
                      <th>Full Name</th>
                      <th>Email Address</th>
                      <th>Phone</th>
                      <th>Sex</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                    <tbody>
                      @foreach($librarian_user as $data)
                        <tr class="text-center">
                          <td>{{$data->name}}</td>
                          <td>{{$data->email}}</td>
                          <td>{{$data->phone}}</td>
                          <td>{{$data->sex}}</td>
                          <td>
                            <button data-id="{{$data->id}}" type="button" class="btn btn-info librarianShowBtn" data-bs-toggle="modal" data-bs-target="#showLibrarianInfo"><i class="bi bi-eye"></i></button>
                            <button data-id="{{$data->id}}" type="button" class="btn btn-primary librarianEditBtn" data-bs-toggle="modal" data-bs-target="#editLibrarianInfo"><i class="bi bi-pencil-square"></i></button>
                            <button data-id="{{$data->id}}" type="button" class="btn btn-danger librarianDeleteBtn"><i class="bi bi-trash"></i></button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
              @elseif ($librarian_user->isEmpty() && request('search'))
                <div class="text-center">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ri-user-unfollow-line" style="font-size: 100px"></i>
                    <h4 class="alert-heading" style="padding-top: 20px">User Not Found</h4>
                    <p>Sorry, the user you are looking for was not found.</p>
                  </div>
                </div>
              @else
                <div class="text-center">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ri-user-unfollow-line" style="font-size: 100px"></i>
                    <h4 class="alert-heading" style="padding-top: 20px">No User Available</h4>
                  </div>
                </div>
              @endif

              <div class="modal fade" id="showLibrarianInfo" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header" >
                      <h5 class="modal-title" >Librarian Information:</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <div class="col-md-12 text-center" style="padding-bottom: 20px">
                          <div id="librarian_avatar"></div>
                      </div>

                      <div class="col-md-12 text-center">
                        <h6><b style="color: rgb(13, 1, 185)">Full Name:  </b><span id="librarian_name"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Email Address:  </b><span id="librarian_email"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Role:  </b><span id="librarian_role"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Address:  </b><span id="librarian_address"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Phone #:  </b><span id="librarian_phone"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Date of Birth:  </b><span id="librarian_birthdate"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Age:  </b><span id="librarian_age"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Sex:  </b><span id="librarian_sex"></span></h6>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="editLibrarianInfo" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" >
                        <h5 class="modal-title" >Edit Book Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form id="librarianInfoForm"  class="row g-3" enctype="multipart/form-data" >
                              @csrf
                              <input type="text" class="form-control" id="librarianEditId" name="librarianEditId" hidden >
                              
                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" name="librarianName" class="form-control" id="librarianName" placeholder="Full Name">
                                  <label for="librarianName">Full Name</label>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" name="librarianEmail" class="form-control" id="librarianEmail" placeholder="Email Address" disabled>
                                  <label for="librarianEmail">Email Address</label>
                                </div>
                              </div>

                              <div class="col-12">
                                  <div class="form-floating">
                                    <textarea name="librarianAddress" class="form-control" placeholder="Address" id="librarianAddress" style="height: 100px;"></textarea>
                                    <label for="librarianAddress">Address</label>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" name="librarianPhone" class="form-control" id="librarianPhone" placeholder="Phone #">
                                  <label for="librarianPhone">Phone #</label>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" name="librarianSex" class="form-control" id="librarianSex" placeholder="Sex">
                                  <label for="librarianSex">Sex</label>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="date" name="librarianBirthdate" class="form-control" id="librarianBirthdate" placeholder="Birthdate">
                                  <label for="librarianBirthdate">Birthdate</label>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" name="librarianAge" class="form-control" id="librarianAge" placeholder="Age">
                                  <label for="librarianAge">Age</label>
                                </div>
                              </div>
                            
                              <div class="col-12" style="padding-top: 20px">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-outline-dark librarianUpdateBtn">Save Changes</button>
                                    <button type="reset" class="btn btn-outline-dark  ms-2">Reset</button>
                                </div>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
              </div>

            </div>
          </div>

          @if ($librarian_user->isNotEmpty())
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                  {{-- Previous Page Link --}}
                  @if ($librarian_user->onFirstPage())
                      <li class="page-item disabled">
                          <span class="page-link">Previous</span>
                      </li>
                  @else
                      <li class="page-item">
                          <a class="page-link" href="{{ $librarian_user->previousPageUrl() }}&search={{ request('search') }}" aria-label="Previous">
                              Previous
                          </a>
                      </li>
                  @endif
          
                  {{-- Pagination Elements --}}
                  @foreach ($librarian_user->links()->elements[0] as $page => $url)
                      <li class="page-item {{ $page == $librarian_user->currentPage() ? 'active' : '' }}">
                          <a class="page-link" href="{{ $url }}&search={{ request('search') }}">{{ $page }}</a>
                      </li>
                  @endforeach
          
                  {{-- Next Page Link --}}
                  @if ($librarian_user->hasMorePages())
                      <li class="page-item">
                          <a class="page-link" href="{{ $librarian_user->nextPageUrl() }}&search={{ request('search') }}" aria-label="Next">
                              Next
                          </a>
                      </li>
                  @else
                      <li class="page-item disabled">
                          <span class="page-link">Next</span>
                      </li>
                  @endif
              </ul>
            </nav>
          @endif

        </div>
      </div>

      
    </section>

</main>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  function showAddLibrarian() {
    document.getElementById('addLibrarianForm').style.display = 'block';
  }

  function toggleAddLibrarian() {
    var addLibrarianForm = document.getElementById('addLibrarianForm');
      if  (addLibrarianForm.style.display === 'none' || addLibrarianForm.style.display === '') {
        addLibrarianForm.style.display = 'block';} 
      else{
        addLibrarianForm.style.display = 'none';
          }
  }
</script>
