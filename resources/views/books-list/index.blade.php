@extends('layouts.navigation')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="assets/img/bookback.png" rel="icon">
<link href="assets/img/bookback.png" rel="apple-touch-icon">
<main id="main" class="main">

    @auth
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            Welcome, {{ Auth::user()->name }}. You're all set—enjoy getting started.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endauth

    @if(session('login_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('login_success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    <div class="pagetitle">
        <h1>BOOK LIST</h1>
    </div>

    <form method="GET" action="{{ route('book.list.index.page') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search Title or Category">
        <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
    </form>

    @if ($books->isNotEmpty())
        @foreach($books as $book)
            <div class="card mb-3">
                <div class="row">
                        <div class="col-md-3 d-flex justify-content-center align-items-center">
                            <div style="padding-top: 20px; padding-bottom: 20px;">
                                <img src="{{ asset('storage/bookPhotos/'.$book->img_path) }}" alt="" style="width: 250px; height: 300px;">
                            </div>
                        </div>
                        <div class="col-md-9 d-flex justify-content-center align-items-center">
                            <div class="card-body">
                                <h5 class="card-title">{{$book->title}}</h5>
                                <p style="font-size: medium;">By: {{$book->author}}</p>
                                <p style="font-size: medium; color: rgb(214, 70, 70);">Category: {{$book->category}}</p>
                                <p>({{$book->summary}})</p>   
                                @if($book->status == 'On Hold for Borrowing') 
                                    <span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> {{$book->status}}</span>
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-outline-dark" type="button" disabled>Borrow Request</button>
                                    </div>
                                @elseif ($book->status == 'Currently Borrowed')
                                    <span class="badge bg-danger"><i class="bi bi-journal-x"></i> {{$book->status}}</span>
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-outline-dark" type="button" disabled>Borrow Request</button>
                                    </div>
                                @else 
                                    <span class="badge bg-success"><i class="bi bi-journal-check"></i> {{$book->status}}</span>
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-outline-dark getBookId" type="button" data-bs-toggle="modal" data-bs-target="#borrowBook" data-id="{{$book->id}}">Borrow Request</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        @endforeach 
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($books->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $books->previousPageUrl() }}&search={{ request('search') }}" aria-label="Previous">
                            Previous
                        </a>
                    </li>
                @endif
        
                {{-- Pagination Elements --}}
                @foreach ($books->links()->elements[0] as $page => $url)
                    <li class="page-item {{ $page == $books->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}&search={{ request('search') }}">{{ $page }}</a>
                    </li>
                @endforeach
        
                {{-- Next Page Link --}}
                @if ($books->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $books->nextPageUrl() }}&search={{ request('search') }}" aria-label="Next">
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
    @elseif ($books->isEmpty() && request('search'))
        <div class="text-center">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-journal-x" style="font-size: 100px"></i>
            <h4 class="alert-heading" style="padding-top: 20px">Book Not Found</h4>
            <p>Sorry, the book you are looking for was not found.</p>
          </div>
        </div>
    @else
        <div class="text-center">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-journal-x" style="font-size: 100px"></i>
            <h4 class="alert-heading" style="padding-top: 20px">No Books Available</h4>
          </div>
        </div>
    @endif

        <div class="modal fade" id="borrowBook" tabindex="-1"> 
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Borrow Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
            
                    <form id="borrowBookForm" class="row g-3" enctype="multipart/form-data">
                        @csrf
            
                        <input type="hidden" class="form-control" id="bookId" name="bookId">
                        <input type="hidden" class="form-control" id="bookTitle" name="bookTitle">
                        <input type="hidden" class="form-control" id="bookCategory" name="bookCategory">
                
                        <div class="col-md-12">
                            <label for="purpose" class="form-label">Purpose of Borrowing Book:</label>
                            <textarea type="text" name="purpose" class="form-control" id="purpose" style="height: 100px;" required></textarea>
                        </div>
                
                        <div class="col-12" style="padding-top: 10px">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-dark btn-sm" id="submitBorrowBook">Submit</button>
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