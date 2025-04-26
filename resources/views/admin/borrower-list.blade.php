@extends('layouts.navigation')
<link href="/assets/img/bookback.png" rel="icon">
<link href="/assets/img/bookback.png" rel="apple-touch-icon">
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Borrower User List</h1>
    </div>

    <form method="GET" action="{{ route('borrower-list.page') }}" class="mb-3 d-flex">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search Name">
      <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
    </form>
  
    <div id="addBorrowerForm" class="col-md-12" style="display: none;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Librarian User</h5>
                  <form class="row g-3" method="POST" action="{{route('borrower-added')}}" enctype="multipart/form-data">
                    @csrf
    
                    <div class="col-md-12">
                      <div class="form-floating">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Full Name">
                        <label for="name">Full Name</label>
                      </div>
                    </div>
    
                    <div class="col-12">
                        <div class="form-floating">
                          <textarea name="address" class="form-control" placeholder="Address" id="address" style="height: 100px;"></textarea>
                          <label for="address">Address</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="date" name="birthdate" class="form-control" id="birthdate" placeholder="Birthdate">
                        <label for="birthdate">Birthdate</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" name="age" class="form-control" id="age" placeholder="Age">
                        <label for="age">Age</label>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="sex" name="sex" aria-label="State">
                          <option selected>---SELECT SEX---</option>
                          <option value="Male">MALE</option>
                          <option value="Female">FEMALE</option>
                        </select>
                        <label for="sex"s>Sex</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Pnone">
                        <label for="phone">Pnone</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email Address">
                        <label for="email">Email Address</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
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
              <h5 class="card-title">LIST OF ALL BORROWER USER</h5>

              <div class="d-grid gap-2 mt-3" style="padding-bottom: 20px">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleAddBorrower()"><i class="ri-user-add-line"></i> ADD BORROWER</button>
              </div>

              @if ($borrower->isNotEmpty())
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
                      @foreach($borrower as $data)
                        <tr class="text-center">
                          <td>{{$data->name}}</td>
                          <td>{{$data->email}}</td>
                          <td>{{$data->phone}}</td>
                          <td>{{$data->sex}}</td>
                          <td>
                            <button data-id="{{$data->id}}" type="button" class="btn btn-info borrowerShowBtn" data-bs-toggle="modal" data-bs-target="#showBorrowerInfo"><i class="bi bi-eye"></i></button>
                            <button data-id="{{$data->id}}" type="button" class="btn btn-primary borrowerEditBtn" data-bs-toggle="modal" data-bs-target="#editBorrowerInfo"><i class="bi bi-pencil-square"></i></button>
                            <button data-id="{{$data->id}}" type="button" class="btn btn-danger borrowerDeleteBtn"><i class="bi bi-trash"></i></button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
              @elseif ($borrower->isEmpty() && request('search'))
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

              {{-- <nav aria-label="Page navigation example">
                <ul class="pagination">
                    @if ($borrower->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $borrower->previousPageUrl() }}" aria-label="Previous">
                                Previous
                            </a>
                        </li>
                    @endif
            
                    @foreach ($borrower->links()->elements[0] as $page => $url)
                        <li class="page-item {{ $page == $borrower->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($borrower->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $borrower->nextPageUrl() }}" aria-label="Next">
                                Next
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    @endif
                </ul>
              </nav> --}}

              <div class="modal fade" id="showBorrowerInfo" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header" >
                      <h5 class="modal-title" >Borrower Information:</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <div class="col-md-12 text-center" style="padding-bottom: 20px">
                          <div id="borrower_avatar"></div>
                      </div>

                      <div class="col-md-12 text-center">
                        <h6><b style="color: rgb(13, 1, 185)">Full Name:  </b><span id="borrower_name"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Email Address:  </b><span id="borrower_email"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Role:  </b><span id="borrower_role"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Address:  </b><span id="borrower_address"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Phone #:  </b><span id="borrower_phone"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Date of Birth:  </b><span id="borrower_birthdate"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Age:  </b><span id="borrower_age"></span></h6>
                        <h6><b style="color: rgb(13, 1, 185)">Sex:  </b><span id="borrower_sex"></span></h6>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="editBorrowerInfo" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" >
                        <h5 class="modal-title" >Edit Borrower Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form id="borrowerInfoForm"  class="row g-3" enctype="multipart/form-data" >
                              @csrf
                              <input type="text" class="form-control" id="borrowerEditId" name="borrowerEditId" hidden >
                              
                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" name="borrowerName" class="form-control" id="borrowerName" placeholder="Full Name">
                                  <label for="borrowerName">Full Name</label>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" name="borrowerEmail" class="form-control" id="borrowerEmail" placeholder="Email Address" disabled>
                                  <label for="borrowerEmail">Email Address</label>
                                </div>
                              </div>

                              <div class="col-12">
                                  <div class="form-floating">
                                    <textarea name="borrowerAddress" class="form-control" placeholder="Address" id="borrowerAddress" style="height: 100px;"></textarea>
                                    <label for="borrowerAddress">Address</label>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" name="borrowerPhone" class="form-control" id="borrowerPhone" placeholder="Phone #">
                                  <label for="borrowerPhone">Phone #</label>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" name="borrowerSex" class="form-control" id="borrowerSex" placeholder="Sex">
                                  <label for="borrowerSex">Sex</label>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="date" name="borrowerBirthdate" class="form-control" id="borrowerBirthdate" placeholder="Birthdate">
                                  <label for="borrowerBirthdate">Birthdate</label>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" name="borrowerAge" class="form-control" id="borrowerAge" placeholder="Age">
                                  <label for="borrowerAge">Age</label>
                                </div>
                              </div>
                            
                              <div class="col-12" style="padding-top: 20px">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-outline-dark borrowerUpdateBtn">Save Changes</button>
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

          @if ($borrower->isNotEmpty())
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                  {{-- Previous Page Link --}}
                  @if ($borrower->onFirstPage())
                      <li class="page-item disabled">
                          <span class="page-link">Previous</span>
                      </li>
                  @else
                      <li class="page-item">
                          <a class="page-link" href="{{ $borrower->previousPageUrl() }}&search={{ request('search') }}" aria-label="Previous">
                              Previous
                          </a>
                      </li>
                  @endif
          
                  {{-- Pagination Elements --}}
                  @foreach ($borrower->links()->elements[0] as $page => $url)
                      <li class="page-item {{ $page == $borrower->currentPage() ? 'active' : '' }}">
                          <a class="page-link" href="{{ $url }}&search={{ request('search') }}">{{ $page }}</a>
                      </li>
                  @endforeach
          
                  {{-- Next Page Link --}}
                  @if ($borrower->hasMorePages())
                      <li class="page-item">
                          <a class="page-link" href="{{ $borrower->nextPageUrl() }}&search={{ request('search') }}" aria-label="Next">
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
  function showAddBorrower() {
    document.getElementById('addBorrowerForm').style.display = 'block';
  }

  function toggleAddBorrower() {
    var addBorrowerForm = document.getElementById('addBorrowerForm');
      if  (addBorrowerForm.style.display === 'none' || addBorrowerForm.style.display === '') {
        addBorrowerForm.style.display = 'block';} 
      else{
        addBorrowerForm.style.display = 'none';
          }
  }
</script>
