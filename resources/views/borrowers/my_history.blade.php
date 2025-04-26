@extends('layouts.navigation')
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
<link href="assets/img/bookback.png" rel="icon">
<link href="assets/img/bookback.png" rel="apple-touch-icon">
<main id="main" class="main">

    <div class="pagetitle">
        <h1>My Book Rental History</h1>
    </div>

    <section class="section">
        <div class="row">
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">List of Your Book Rentals</h5>

                @if ($history->isNotEmpty())
                  <div class="list-group">
                    @foreach($history as $data)
                      <a href="" data-id="{{$data->id}}" class="list-group-item list-group-item-action bookTransactShowBtn" data-bs-toggle="modal" data-bs-target="#showBookTransactionInfo">
                        <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1"><strong>{{$data->book_title}}</strong></h5>
                          <medium class="text-muted">
                            @if($data->status == 'Pending') 
                              <span class="badge bg-warning">{{$data->status}} Request</span>
                            @elseif ($data->status == 'Currently Borrowed')
                              <span class="badge bg-primary">Request Approved</span>
                            @elseif ($data->status == 'Rejected')
                              <span class="badge bg-danger">Request Rejected</span>
                            @elseif ($data->status == 'Book Returned')
                              <span class="badge bg-success">Book Returned</span>
                            @endif
                          </medium>
                        </div>
                        <p class="mb-1">({{$data->book_category}})</p>
                        <small class="text-muted">
                          {{ \Carbon\Carbon::parse($data->book_borrowing_date)->diffForHumans() }}
                        </small>
                      </a>
                    @endforeach
                  </div>
                @else
                  <div class="text-center">
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-question-lg" style="font-size: 100px"></i>
                        <h4 class="alert-heading" style="padding-top: 20px">No History Listings at the Moment</h4>
                      </div>
                  </div>
                @endif

                <div class="modal fade" id="showBookTransactionInfo" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" >
                        <h5 class="modal-title" >Book Transaction Information:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <div class="row g-0">
                          <div class="col-md-12 text-center" style="padding-bottom: 20px">
                              <div id="bookphoto"></div>
                          </div>
    
                          <div class="col-md-12 text-center">
                            <h6><b style="color: rgb(13, 1, 185)">Book Title:  </b><span id="name"></span></h6>
                            <h6><b style="color: rgb(13, 1, 185)">Book Author:  </b><span id="author"></span></h6>
                            <h6><b style="color: rgb(13, 1, 185)">Book Category:  </b><span id="category"></span></h6>
                            <h6><b style="color: rgb(13, 1, 185)">Reason for Borrowing:  </b><span id="purpose"></span></h6>
                            <h6><b style="color: rgb(13, 1, 185)">Book Checkout:  </b><span id="book_checkout"></span></h6>
                            <h6><b style="color: rgb(13, 1, 185)">Book Due Date:  </b><span id="book_due_date"></span></h6>
                            <h6><b style="color: rgb(13, 1, 185)">Transaction Status:  </b><span id="status"></span></h6>
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

            <nav aria-label="Page navigation example">
              <ul class="pagination">
                  @if ($history->onFirstPage())
                      <li class="page-item disabled">
                          <span class="page-link">Previous</span>
                      </li>
                  @else
                      <li class="page-item">
                          <a class="page-link" href="{{ $history->previousPageUrl() }}" aria-label="Previous">
                              Previous
                          </a>
                      </li>
                  @endif
          
                  @foreach ($history->links()->elements[0] as $page => $url)
                      <li class="page-item {{ $page == $history->currentPage() ? 'active' : '' }}">
                          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                      </li>
                  @endforeach

                  @if ($history->hasMorePages())
                      <li class="page-item">
                          <a class="page-link" href="{{ $history->nextPageUrl() }}" aria-label="Next">
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

  
          </div>
        </div>
    </section>

</main>