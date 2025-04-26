@extends('layouts.navigation')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="/assets/img/bookback.png" rel="icon">
<link href="/assets/img/bookback.png" rel="apple-touch-icon">
<style>
    .carousel-inner img {
      width: 400px;
      height: 400px;
      object-fit: cover; 
      margin: auto; 
    }
  
    .carousel {
      max-width: 400px; 
      margin: auto; 
    }
</style>
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
          <h1>Book Rental Tracker</h1>
      </div>

      <form method="GET" action="{{ route('reminder') }}" class="mb-3 d-flex">
          <select name="search" class="form-control me-2">
              <option value="" disabled selected>Select a Search Option</option>
              <option value="1_day_ahead" {{ request('search') == '1_day_ahead' ? 'selected' : '' }}>1 Day Ahead</option>
              <option value="2_days_ahead" {{ request('search') == '2_days_ahead' ? 'selected' : '' }}>2 Days Ahead</option>
              <option value="3_days_ahead" {{ request('search') == '3_days_ahead' ? 'selected' : '' }}>3 Days Ahead</option>
              <option value="overdue" {{ request('search') == 'overdue' ? 'selected' : '' }}>Overdue</option>
          </select>
          <button type="submit" class="btn btn-outline-primary btn-sm"> Submit</button>
      </form>
  
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">List of All Books Transaction / Rentals</h5>
  
                @if ($transaction->isNotEmpty())
                  <table class="table table-hover">
                    <thead>
                      <tr class="text-center">
                        <th>Days left</th>
                        <th>Checkout Date</th>
                        <th>Due Date</th>
                        <th>Borrower's Name</th>
                        <th>Book Title</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                      <tbody>
                        @foreach($transaction as $data)
                          <tr class="text-center">
                            <td>
                                @if ($data->due_date == 'TBA')
                                    TBA
                                @elseif ($data->due_date == 'Unknown')
                                    UNKNOWN
                                @else
                                    @php
                                        if ($data->due_date != 'Unknown') {
                                            $dueDate = \Carbon\Carbon::parse($data->due_date);
                                            $today = \Carbon\Carbon::today();
                                            $remainingDays = $today->diffInDays($dueDate, false); 
                                        } else {
                                            $remainingDays = null; 
                                        }
                                    @endphp
                                    @if ($remainingDays === null)
                                        Due date unknown
                                    @elseif ($remainingDays > 0)
                                        @if ($remainingDays == 1)
                                          <span class="badge bg-secondary">1 DAY</span>
                                        @else
                                          <span class="badge bg-success">{{ $remainingDays }} DAYS</span>
                                        @endif
                                    @elseif ($remainingDays < 0)
                                      <span class="badge bg-danger">DUE DATE PASSED</span>
                                    @else
                                      <span class="badge bg-warning">DUE DATE IS TODAY</span>
                                    @endif
                                @endif
                            </td>                  

                            <td>
                                {{ \Carbon\Carbon::parse($data->book_borrowing_date)->format('Y-m-d') }}
                            </td>
  
                            <td>
                                @if($data->due_date == 'TBA')
                                    TBA
                                @elseif ($data->due_date == 'Unknown')
                                    UNKNOWN
                                @else
                                    {{ \Carbon\Carbon::parse($data->due_date)->format('Y-m-d') }}
                                @endif
                            </td>
                   
                            <td>
                                <button data-id="{{$data->borrower_id}}" type="button" class="btn btn-link text-decoration-none showBorrowerInfo" data-bs-toggle="modal" data-bs-target="#borrowerInfo">
                                  {{$data->borrower_name}}
                                </button>
                            </td>

                            <td>
                                <button data-id="{{$data->book_id}}" type="button" class="btn btn-link text-decoration-none showBookInfo" data-bs-toggle="modal" data-bs-target="#bookInfo">
                                  {{$data->book_title}}
                                </button>
                            </td>

                            <td>
                              <button data-id="{{$data->id}}" type="button" class="btn btn-success transactionID" data-bs-toggle="modal" data-bs-target="#manualEmail"><i class="bx bxs-bell-ring"></i></button>
                              <button data-id="{{$data->id}}" type="button" class="btn btn-primary transactionDone"><i class="bx bxs-arrow-to-left"></i></button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
                @elseif ($transaction->isEmpty() && request('search'))
                  <div class="text-center">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <i class="bi bi-question-lg" style="font-size: 100px"></i>
                      <h4 class="alert-heading" style="padding-top: 20px">Not Found</h4>
                      <p>Sorry, we couldn’t find the borrowing log you’re looking for.</p>
                    </div>
                  </div>
                @else
                  <div class="text-center">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <i class="bi bi-question-lg" style="font-size: 100px"></i>
                      <h4 class="alert-heading" style="padding-top: 20px">No Borrowing Logs Available</h4>
                    </div>
                  </div>
                @endif
  
                <div class="modal fade" id="borrowerInfo" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" >
                        <h5 class="modal-title" >Borrower Information:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
  
                        <div class="col-md-12 text-center" style="padding-bottom: 20px">
                            <div id="avatarBorrower"></div>
                        </div>
  
                        <div class="col-md-12 text-center">
                          <h6><b style="color: rgb(13, 1, 185)">Full Name:  </b><span id="nameBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Email Address:  </b><span id="emailBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Role:  </b><span id="roleBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Address:  </b><span id="addressBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Phone #:  </b><span id="phoneBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Date of Birth:  </b><span id="birthdateBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Age:  </b><span id="ageBorrower"></span></h6>
                          <h6><b style="color: rgb(13, 1, 185)">Sex:  </b><span id="sexBorrower"></span></h6>
                        </div>
  
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div class="modal fade" id="bookInfo" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" >
                        <h5 class="modal-title" >Book Information:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
  
                          <div class="row g-0">
                            <div id="book_image" class="col-md-12 text-center">
                              
                              <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>
                              
                                <div class="carousel-inner">
                                  <div class="carousel-item active">
                                    <img src="https://i.ebayimg.com/images/g/7e0AAOSwrjpg0Rki/s-l1200.jpg" class="d-block" alt="Image 1">
                                  </div>
                                  <div class="carousel-item">
                                    <img src="https://junealholder.blog/wp-content/uploads/2019/05/img_20190505_155026_731.jpg" class="d-block" alt="Image 2">
                                  </div>
                                  <div class="carousel-item">
                                    <img src="https://i.ebayimg.com/images/g/7e0AAOSwrjpg0Rki/s-l1200.jpg" class="d-block" alt="Image 3">
                                  </div>
                                </div>
                              
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Next</span>
                                </button>
                              </div>
                            </div>
                            
                            <div class="col-md-12 text-center">
                              <div class="card-body">
                                  <h5 id="bookname" class="card-title"></h5>
                                  <h6 id="bookcategory"></h6>
                                  <h6 id="booksummary"></h6>
                              </div>
                            </div>
                          </div>
      
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="manualEmail" tabindex="-1"> 
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Sending Manual Email</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                  
                          <form class="row g-3" enctype="multipart/form-data" method="POST" action="{{ route('manual-email-send') }}" style="padding-top: 30px;">
                              @csrf
                  
                              <input type="hidden" class="form-control" id="transactionID" name="transactionID">
                              <input type="hidden" class="form-control" id="bookID" name="bookID">
                              <input type="hidden" class="form-control" id="userID" name="userID">
      
                              <div class="col-12 text-center">
                                <label for="inputState" class="form-label">Select the type of email notification you want to send:</label>
                                  <select id="emailType" class="form-select" name="emailType" required>
                                    <option selected>Choose...</option>
                                    <option value="OneDayAhead">1 Day Ahead Before Due</option>
                                    <option value="DueToday">Due Today</option>
                                    <option value="Overdue">Overdue</option>
                                  </select>
                              </div>
                      
                              <div class="col-12">
                                  <div class="d-flex justify-content-end">
                                      <button type="submit" class="btn btn-outline-dark btn-sm">Send</button>
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
  
            @if ($transaction->isNotEmpty())
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($transaction->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $transaction->previousPageUrl() }}&search={{ request('search') }}" aria-label="Previous">
                                Previous
                            </a>
                        </li>
                    @endif
            
                    {{-- Pagination Elements --}}
                    @foreach ($transaction->links()->elements[0] as $page => $url)
                        <li class="page-item {{ $page == $transaction->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}&search={{ request('search') }}">{{ $page }}</a>
                        </li>
                    @endforeach
            
                    {{-- Next Page Link --}}
                    @if ($transaction->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $transaction->nextPageUrl() }}&search={{ request('search') }}" aria-label="Next">
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