@extends('layouts.navigation')
<link href="/assets/img/bookback.png" rel="icon">
<link href="/assets/img/bookback.png" rel="apple-touch-icon">
<main id="main" class="main">

    <div class="pagetitle">
        <h1>ALL PENDING BOOK RENTAL REQUESTS</h1>
    </div>

        @if ($transaction->isNotEmpty())
        <div class="list-group">
            @foreach($transaction as $data)
                <a href="" data-id="{{$data->id}}" class="list-group-item list-group-item-action getTransactionId" data-bs-toggle="modal" data-bs-target="#process" style="padding-top: 20px; padding-bottom: 20px;">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1"><span class="card-title">{{$data->book_title}}</span> <span style="font-size: smallr">({{$data->book_category}})</span></h6>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($data->book_borrowing_date)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1"><strong style="color: red">Purpose of Borrowing: </strong> {{$data->purpose}}</p>
                    <small class="text-muted"><strong style="color: red">Borrower: </strong> {{$data->borrower_name}}</small>
                </a>
            @endforeach
        </div>
        @else
            <div class="text-center">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 40px">
                    <i class="bi bi-journal-x" style="font-size: 100px;"></i>
                    <h4 class="alert-heading" style="padding-top: 20px">No Pending Rentals</h4>
                    <p>There are no pending book rental requests.</p>
                </div>
            </div>
        @endif

        @if ($transaction->isNotEmpty())
            <nav aria-label="Page navigation example" style="padding-top: 15px">
                <ul class="pagination">
                    @if ($transaction->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $transaction->previousPageUrl() }}" aria-label="Previous">
                                Previous
                            </a>
                        </li>
                    @endif
            
                    @foreach ($transaction->links()->elements[0] as $page => $url)
                        <li class="page-item {{ $page == $transaction->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
            
                    @if ($transaction->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $transaction->nextPageUrl() }}" aria-label="Next">
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

        <div class="modal fade" id="process" tabindex="-1"> 
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Processing Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
            
                    <form id="processingform" class="row g-3" enctype="multipart/form-data" style="padding-top: 30px;">
                        @csrf
            
                        <input type="hidden" class="form-control" id="transactionId" name="transactionId">
                        <input type="hidden" class="form-control" id="bookid" name="bookid">

                        <div class="col-12 text-center">
                            <label class="form-label">Will this request be approved or not?</label>
                                <select class="form-select" aria-label="Default select example" name="status" id="statusSelect">
                                    <option selected disabled>Open this select menu</option>
                                    <option value="Currently Borrowed">Approve</option>
                                    <option value="Reject">Reject</option>
                                </select>
                        </div>
                        
                        <div id="dueDateContainer" class="col-12 text-center" style="display: none;">
                            <label for="due_date" class="form-label">Set Due Date for Book Return</label>
                            <input type="date" class="form-control" name="due_date" id="due_date">
                        </div>
                
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-dark btn-sm" id="submit_process">Submit</button>
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

</main>
<script>
    document.getElementById('statusSelect').addEventListener('change', function () {
        const dueDateContainer = document.getElementById('dueDateContainer');
        if (this.value === 'Currently Borrowed') {
            dueDateContainer.style.display = '';
        } else {
            dueDateContainer.style.display = 'none';
        }
    });
</script>