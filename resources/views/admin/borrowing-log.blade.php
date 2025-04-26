@extends('layouts.navigation')
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

    <div class="pagetitle">
        <h1>Borrowing Log</h1>
    </div>

    <form method="GET" action="{{ route('borrowing-log') }}" class="mb-3 d-flex">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search Borrower Name / Checkout Date / Due Date">
      <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
    </form>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Record of All Borrowed Books</h5>

              @if ($transaction->isNotEmpty())
                <table class="table table-hover">
                  <thead>
                    <tr class="text-center">
                      <th>Borrower's Name</th>
                      <th>Book Title</th>
                      <th>Checkout Date</th>
                      <th>Due Date</th>
                      <th>Status</th>           
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($transaction as $data)
                        <tr class="text-center">
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

                          <td>{{ \Carbon\Carbon::parse($data->book_borrowing_date)->format('Y-m-d') }}</td>

                          @if($data->due_date == 'TBA') 
                            <td>TBA</td>
                          @elseif ($data->due_date == 'Unknown') 
                            <td>UNKNOWN</td>
                          @else
                            <td>{{ \Carbon\Carbon::parse($data->due_date)->format('Y-m-d') }}</td>
                          @endif

                          @if($data->status == 'Pending') 
                            <td><span class="badge bg-warning">Pending Request</span></td>
                          @elseif ($data->status == 'Currently Borrowed')
                            <td><span class="badge bg-primary">{{$data->status}}</span></td>
                          @elseif ($data->status == 'Rejected')
                            <td><span class="badge bg-danger">Request Rejected</span></td>
                          @elseif ($data->status == 'Book Returned')
                            <td><span class="badge bg-success">{{$data->status}}</span></td>
                          @endif
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
                          <div id="book_image" class="col-md-12 text-center"></div>
                          
                          <div class="col-md-12 text-center">
                            <div class="card-body">
                                <h5 id="bookname" class="card-title"></h5>
                                <h6 id="bookauthor"></h6>
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
