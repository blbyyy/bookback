$(document).ready(function () {

    //admin/librarian show book information
    $(".bookShowBtn").click(function() {
        var id = $(this).data("id");
    
        $.ajax({
            type: "GET",
            url: "/admin/show/book/" + id,
            dataType: "json",
            success: function(data) { 
                console.log("Received Data:", data); 

                if (data.book) {
                    $("#name").text(data.book.title);
                    $("#author").text("By: " + data.book.author);
                    $("#category").text("(" + data.book.category + ")");
                    $("#summary").text(data.book.summary);

                    if (data.book.img_path === "bookphoto.jpg") {
                        $("#book_photo").html('<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Ffavpng.com%2Fpng_view%2Flivres-question-mark-book-cover-clip-art-png%2FZf7UDEmR&psig=AOvVaw0g_EQisTo8HLh7PN2SqFct&ust=1745342261254000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCJjNw_fQ6YwDFQAAAAAdAAAAABAE" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                    } else {
                        $("#book_photo").html('<img src="/storage/bookPhotos/' + data.book.img_path + '" class="img-fluid rounded-start" alt="..." style="width: 350px; height: 350px;"></img>');
                    }

                } else {
                    $("#name").text("Book not found");
                    $("#category").text("");
                    $("#summary").text("");
                }            
                
            },
            error: function(error) {
                console.log("Error:", error);
                alert("Error fetching book details");
            }
        });
    });
    
    //admin/librarian edit book info
    $(".bookEditBtn").click(function() {
        var id = $(this).data("id");
        
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/admin/show/book/" + id + "/edit/",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) { 
                console.log(data);
                $('#bookEditId').val(data.id);
                $('#bookTitle').val(data.title);
                $('#bookSummary').val(data.summary);
                $('#bookCategory').val(data.category);
                $('#bookAuthor').val(data.author);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //admin/librarian update borrower info
    $(".bookUpdateBtn").on("click", function (e) {
        e.preventDefault();
        var id = $("#bookEditId").val();
        let editformData = new FormData($("#bookInfoForm")[0]);
        for(var pair of editformData.entries()){
            console.log(pair[0] + ',' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/admin/book-catalog/show/" + id + "/edit/update",
            data: editformData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                setTimeout(function() {
                    window.location.href = '/admin/book-catalog';
                }, 2000);
                console.log(data);
                Swal.fire({
                    title: 'Book Info Updated!',
                    text: 'Book Info Was Successfully Updated',
                    icon: 'success',
                    showConfirmButton: false
                });
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //admin/librarian deleting book 
    $(".bookDeleteBtn").on("click", function (e) {
        
        var id = $(this).data("id");
        console.log(id);
        Swal.fire({
            title: 'Are you sure you want to delete this book?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "DELETE",
                    url: "/api/admin/book/" + id + "/deleted",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        setTimeout(function() {
                            window.location.href = '/admin/book-catalog';
                        }, 1500);
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'Book has been deleted.',
                            'success'
                        )
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });

            }
        })

    });

    //admin/librarian geting book id for showing details of book
    $(".getBookId").click(function() {
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/borrower/get/book/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
    
                $('#bookId').val(id);
                $('#bookTitle').val(data.title);
                $('#bookCategory').val(data.category);
    
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    //borrowers sending borrowing request
    $("#submitBorrowBook").on("click", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        let editformData = new FormData($("#borrowBookForm")[0]);
            for(var pair of editformData.entries()){
                console.log(pair[0] + ',' + pair[1]);
            }
        $.ajax({
            type: "POST",
            url: "/borrower/book/transaction/" + id ,
            data: editformData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                setTimeout(function() {
                    window.location.href = '/book-list';
                }, 2000);
                console.log(data);
                Swal.fire(
                    'Request Sent!',
                    'Request successfully sent. Waiting for admin confirmation.',
                    'success'
                )
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //borrowers show book_transaction information
    $(".bookTransactShowBtn").click(function() {
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "/my-history/show/book-transaction/" + id,
            dataType: "json",
            success: function(data) { 
                console.log("Received Data:", data); 

                if (data.history) {
                    $("#name").text(data.history.book_title);
                    $("#category").text("(" + data.history.book_category + ")");
                    $("#purpose").text(data.history.purpose);
                    $("#book_checkout").text(data.history.book_borrowing_date.split(" ")[0]);
                    $("#book_due_date").text(data.history.due_date);
                    $("#author").text("By: " + data.history.author);

                    if (data.history.status === 'Currently Borrowed') {
                        $("#status").text('Request Approved').css('color', 'blue').css('font-weight', 'bold');
                    }else if (data.history.status === 'Rejected') {
                        $("#status").text('Request Rejected').css('color', 'red').css('font-weight', 'bold');
                    }else if (data.history.status === 'Book Returned') {
                        $("#status").text('Book Returned').css('color', 'green').css('font-weight', 'bold');
                    } 

                    if (data.history.img_path === "bookphoto.jpg") {
                        $("#bookphoto").html('<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Ffavpng.com%2Fpng_view%2Flivres-question-mark-book-cover-clip-art-png%2FZf7UDEmR&psig=AOvVaw0g_EQisTo8HLh7PN2SqFct&ust=1745342261254000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCJjNw_fQ6YwDFQAAAAAdAAAAABAE" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                    } else {
                        $("#bookphoto").html('<img src="/storage/bookPhotos/' + data.history.img_path + '" class="img-fluid rounded-start" alt="..." style="width: 350px; height: 350px;"></img>');
                    }

                } else {
                    $("#name").text("Book not found");
                    $("#category").text("");
                    $("#summary").text("");
                }
                
            },
            error: function(error) {
                console.log("Error:", error);
                alert("Error fetching book details");
            }
        });
    });

    //admin/librarian show librarian information
    $(".librarianShowBtn").click(function() {
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/admin/librarian-list/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.avatar === "avatar.jpg") {
                    $("#librarian_avatar").html('<img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                } else {
                    $("#librarian_avatar").html('<img src="/storage/avatars/' + data.avatar + '" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                }
    
                $('#librarian_name').text(data.name);
                $('#librarian_email').text(data.email);
                $('#librarian_address').text(data.address);
                $('#librarian_birthdate').text(data.birthdate);
                $('#librarian_age').text(data.age);
                $('#librarian_sex').text(data.sex);
                $('#librarian_phone').text(data.phone);
                $('#librarian_role').text(data.role);
    
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    //admin/librarian edit librarian info
    $(".librarianEditBtn").click(function() {
        var id = $(this).data("id");
        
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/admin/librarian-list/" + id + "/edit/",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) { 
                console.log(data);
                $('#librarianEditId').val(data.id);
                $('#librarianName').val(data.name);
                $('#librarianEmail').val(data.email);
                $('#librarianAddress').val(data.address);
                $('#librarianPhone').val(data.phone);
                $('#librarianSex').val(data.sex);
                $('#librarianBirthdate').val(data.birthdate);
                $('#librarianAge').val(data.age);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //admin/librarian update librarian info
    $(".librarianUpdateBtn").on("click", function (e) {
        e.preventDefault();
        var id = $("#librarianEditId").val();
        let editformData = new FormData($("#librarianInfoForm")[0]);
        for(var pair of editformData.entries()){
            console.log(pair[0] + ',' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/admin/librarian-list/" + id + "/update",
            data: editformData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                setTimeout(function() {
                    window.location.href = '/admin/librarian-list';
                }, 2000);
                console.log(data);
                Swal.fire(
                    'Info Updated!',
                    'Librarian Info Was Successfully Updated',
                    'success'
                )
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //admin/librarian deleting librarian info
    $(".librarianDeleteBtn").on("click", function (e) {
        var id = $(this).data("id");
        console.log(id);
        Swal.fire({
            title: 'Are you sure you want to delete this user?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/api/admin/librarian-list/" + id + "/deleted",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        setTimeout(function() {
                            window.location.href = '/admin/librarian-list';
                        }, 1500);
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'User has been deleted.',
                            'success'
                        )
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });

            }
        })

    });

    //admin/librarian show borrower information
    $(".borrowerShowBtn").click(function() {
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/admin/borrower-list/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.avatar === "avatar.jpg") {
                    $("#borrower_avatar").html('<img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                } else {
                    $("#borrower_avatar").html('<img src="/storage/avatars/' + data.avatar + '" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                }
    
                $('#borrower_name').text(data.name);
                $('#borrower_email').text(data.email);
                $('#borrower_address').text(data.address);
                $('#borrower_birthdate').text(data.birthdate);
                $('#borrower_age').text(data.age);
                $('#borrower_sex').text(data.sex);
                $('#borrower_phone').text(data.phone);
                $('#borrower_role').text(data.role);
    
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    //admin/librarian edit borrower info
    $(".borrowerEditBtn").click(function() {
        var id = $(this).data("id");
        
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/admin/borrower-list/" + id + "/edit/",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) { 
                console.log(data);
                $('#borrowerEditId').val(data.id);
                $('#borrowerName').val(data.name);
                $('#borrowerEmail').val(data.email);
                $('#borrowerAddress').val(data.address);
                $('#borrowerPhone').val(data.phone);
                $('#borrowerSex').val(data.sex);
                $('#borrowerBirthdate').val(data.birthdate);
                $('#borrowerAge').val(data.age);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //admin/librarian update borrower info
    $(".borrowerUpdateBtn").on("click", function (e) {
        e.preventDefault();
        var id = $("#borrowerEditId").val();
        let editformData = new FormData($("#borrowerInfoForm")[0]);
        for(var pair of editformData.entries()){
            console.log(pair[0] + ',' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/admin/borrower-list/" + id + "/update",
            data: editformData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                setTimeout(function() {
                    window.location.href = '/admin/borrower-list';
                }, 2000);
                console.log(data);
                Swal.fire(
                    'Info Updated!',
                    'Borrower Info Was Successfully Updated',
                    'success'
                )
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //admin/librarian deleting borrower info
    $(".borrowerDeleteBtn").on("click", function (e) {
        var id = $(this).data("id");
        console.log(id);
        Swal.fire({
            title: 'Are you sure you want to delete this user?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/api/admin/borrower-list/" + id + "/deleted",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        setTimeout(function() {
                            window.location.href = '/admin/borrower-list';
                        }, 1500);
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'User has been deleted.',
                            'success'
                        )
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });

            }
        })

    });

    //admin/librarian show borrower information in borrowing log
    $(".showBorrowerInfo").click(function() {
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/admin/borrowing-log/borrower/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.avatar === "avatar.jpg") {
                    $("#avatarBorrower").html('<img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                } else {
                    $("#avatarBorrower").html('<img src="/storage/avatars/' + data.avatar + '" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                }
    
                $('#nameBorrower').text(data.name);
                $('#emailBorrower').text(data.email);
                $('#roleBorrower').text(data.address);
                $('#addressBorrower').text(data.birthdate);
                $('#phoneBorrower').text(data.age);
                $('#birthdateBorrower').text(data.sex);
                $('#ageBorrower').text(data.phone);
                $('#sexBorrower').text(data.sex);
    
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    //admin/librarian show book information in borrowing log
    $(".showBookInfo").click(function() {
        var id = $(this).data("id");
    
        $.ajax({
            type: "GET",
            url: "/admin/borrowing-log/book/" + id,
            dataType: "json",
            success: function(data) { 
                console.log("Received Data:", data); 

                if (data.book) {
                    $("#bookname").text(data.book.title);
                    $("#bookcategory").text("(" + data.book.category + ")");
                    $("#booksummary").text(data.book.summary);
                    $("#bookauthor").text("By: " + data.book.author);

                    if (data.book.img_path === "bookphoto.jpg") {
                        $("#book_image").html('<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Ffavpng.com%2Fpng_view%2Flivres-question-mark-book-cover-clip-art-png%2FZf7UDEmR&psig=AOvVaw0g_EQisTo8HLh7PN2SqFct&ust=1745342261254000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCJjNw_fQ6YwDFQAAAAAdAAAAABAE" class="img-fluid rounded-start" alt="..." style="width: 250px; height: 250px;"></img>');
                    } else {
                        $("#book_image").html('<img src="/storage/bookPhotos/' + data.book.img_path + '" class="img-fluid rounded-start" alt="..." style="width: 350px; height: 350px;"></img>');
                    }

                } else {
                    $("#name").text("Book not found");
                    $("#category").text("");
                    $("#summary").text("");
                }         
                
            },
            error: function(error) {
                console.log("Error:", error);
                alert("Error fetching book details");
            }
        });
    });
    
    //admin/librarian geting transaction id for processing book request
    $(".getTransactionId").click(function() {
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/admin/book-rentals/process/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
    
                $('#transactionId').val(id);
                $('#bookid').val(data.book_id);

            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    //admin/librarian processing borrowing request
    $("#submit_process").on("click", function (e) {
        e.preventDefault();
        var id = $("#transactionId").val();
        console.log(id);
        let editformData = new FormData($("#processingform")[0]);
            for(var pair of editformData.entries()){
                console.log(pair[0] + ',' + pair[1]);
            }
        $.ajax({
            type: "POST",
            url: "/admin/book-rentals/process/" + id + "/sent" ,
            data: editformData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                setTimeout(function() {
                    window.location.href = '/admin/book-rentals';
                }, 2000);
                console.log(data);
                Swal.fire(
                    'Process Done',
                    'This process will be done',
                    'success'
                )
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //notification badge
    $(".notificationBell").click(function() {
        $.ajax({
            url: "/notification/is-read",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 
            },
            success: function(data) {
                $(".badge-number").hide();
            }, 
            error: function(xhr, status, error) {
                console.log(xhr.responseText, error, status); 
            }
        });
    });

    //admin/librarian updating book/transaction status
    $(".transactionDone").on("click", function (e) {
        var id = $(this).data("id");
        console.log(id);
        Swal.fire({
            title: 'Are you sure this book has been returned?',
            text: "You can’t undo this once the book is marked as returned!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: "/admin/updating/transaction-status/" + id,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                
                        Swal.fire(
                            'Mark as Returned',
                            'Book has been returned.',
                            'success'
                        );
                
                        setTimeout(function() {
                            window.location.href = '/admin/reminder';
                        }, 1500);
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });                

            }
        })

    });

     //admin/librarian getting transaction id to send manual email notification
     $(".transactionID").click(function() {
        var id = $(this).data("id");
        
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/admin/transaction/" + id + "/onedayahead/",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) { 
                console.log(data);
                $('#transactionID').val(data.id);
                $('#bookID').val(data.book_id);
                $('#userID').val(data.borrower_id);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});