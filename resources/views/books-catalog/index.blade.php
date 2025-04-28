@extends('layouts.navigation')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="{{ asset('assets/img/bookback.png') }}" rel="icon">
<link href="{{ asset('assets/img/bookback.png') }}" rel="apple-touch-icon">
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
        <h1>BOOK CATALOG</h1>
    </div>

    <form method="GET" action="{{ route('book.catalog.index.page') }}" class="mb-3 d-flex">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search Title or Category">
      <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
    </form>

    <div id="addBookForm" class="col-md-12" style="display: none;">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title">Add Book</h5>
                <form class="row g-3" method="POST" action="{{ route('book-added')}}" enctype="multipart/form-data">
                  @csrf
  
                  <div class="col-12">
                      <div class="form-floating">
                        <textarea name="book_title" class="form-control" placeholder="Book Title" id="book_title" style="height: 100px;"></textarea>
                        <label for="book_title">Book Title</label>
                      </div>
                  </div>

                  <div class="col-12">
                    <div class="form-floating">
                      <input name="book_author" name="book_author" class="form-control" id="book_author" placeholder="Book Author">
                      <label for="book_author">Book Author</label>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-floating">
                      <input type="text" name="book_category" class="form-control" id="book_category" placeholder="Book Category">
                      <label for="book_category">Book Category</label>
                    </div>
                  </div>
  
                  <div class="col-12">
                      <div class="form-floating">
                        <textarea name="book_summary" class="form-control" placeholder="Book Summary/Description" id="book_summary" style="height: 300px;"></textarea>
                        <label for="book_summary">Book Summary/Description</label>
                      </div>
                  </div>
  
                  <div class="col-md-12">
                    <label for="content" class="form-label">Book Image</label>
                    <input name="bookphoto" type="file" class="form-control" id="bookphoto">
                  </div>
                  
                  <div class="col-12" >
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Add</button>
                        <button type="reset" class="btn btn-outline-dark ms-2" onclick="toggleAddBook()">Close</button>
                    </div>
                  </div>

                </form>
          </div>
      </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">LIST OF ALL BOOKS</h5>

            <div class="d-grid gap-2 mt-3" style="padding-bottom: 20px">
              <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleAddBook()"><i class="ri-health-book-line"></i> ADD BOOK</button>
            </div>
            
            @if ($books->isNotEmpty())
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Title</th>
                      <th scope="col">Category</th>
                      <th scope="col">Summary</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($books as $book)
                      <tr>
                        <td>{{$book->title}}</td>
                        <td>{{$book->category}}</td>
                        <td>{{$book->summary}}</td>
                        <td style="width: 200px">
                          <button data-id="{{$book->id}}" type="button" class="btn btn-info bookShowBtn" data-bs-toggle="modal" data-bs-target="#showBookInfo"><i class="bi bi-eye"></i></button>
                          <button data-id="{{$book->id}}" type="button" class="btn btn-primary bookEditBtn" data-bs-toggle="modal" data-bs-target="#editBookInfo"><i class="bi bi-pencil-square"></i></button>
                          <button data-id="{{$book->id}}" type="button" class="btn btn-danger bookDeleteBtn"><i class="bi bi-trash"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
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

            <div class="modal fade" id="showBookInfo" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header" >
                      <h5 class="modal-title" >Book Information:</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row g-0">
                          <div class="col-md-12 text-center" style="padding-bottom: 20px">
                            <div id="book_photo"></div>
                          </div>
                          
                          <div class="col-md-12 text-center">
                            <div class="card-body">
                                <h5 id="name" class="card-title"></h5>
                                <h6 id="author"></h6>
                                <h6 id="category"></h6>
                                <h6 id="summary"></h6>
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

            <div class="modal fade" id="editBookInfo" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header" >
                      <h5 class="modal-title" >Edit Book Information</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="bookInfoForm" class="row g-3" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" class="form-control" id="bookEditId" name="bookEditId" hidden >
                            
                            <div class="col-12">
                                <div class="form-floating">
                                  <textarea name="bookTitle" class="form-control" placeholder="Book Title" id="bookTitle" style="height: 100px;"></textarea>
                                  <label for="bookTitle">Book Title/Name</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-floating">
                                <input type="text" name="bookAuthor" class="form-control" id="bookAuthor" placeholder="Book Author">
                                <label for="bookAuthor">Book Author</label>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-floating">
                                <input type="text" name="bookCategory" class="form-control" id="bookCategory" placeholder="Book Category">
                                <label for="bookCategory">Book Category</label>
                              </div>
                            </div>
                
                            <div class="col-12">
                                <div class="form-floating">
                                  <textarea name="bookSummary" class="form-control" placeholder="Book Summarry/Description" id="bookSummary" style="height: 300px;"></textarea>
                                  <label for="bookSummary">Book Summarry/Description</label>
                                </div>
                            </div>
                           
                            <div class="col-12" style="padding-top: 20px">
                              <div class="d-flex justify-content-end">
                                  <button type="submit" class="btn btn-outline-dark bookUpdateBtn">Save Changes</button>
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

    @if ($books->isNotEmpty())
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
    @endif

</main>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  function showAddBook() {
    document.getElementById('addBookForm').style.display = 'block';
  }

  function toggleAddBook() {
    var addBookForm = document.getElementById('addBookForm');
      if  (addBookForm.style.display === 'none' || addBookForm.style.display === '') {
        addBookForm.style.display = 'block';} 
      else{
        addBookForm.style.display = 'none';
          }
  }
</script>
