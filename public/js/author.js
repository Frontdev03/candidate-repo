$(document).ready(function () {
    $('.deleteAuthor').hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Use the correct selector for the close button
    $('.btn-close').on('click', function () {
        $('#authorModal').modal('hide');
    });

    $('#closeModal').on('click', function () {
        $('#authorModal').modal('hide');
    });

    $('.viewAuthor').on('click', function () {
        const authorId = $(this).data('id');

        $('#loader').show();

        $.ajax({
            url: `/authors/${authorId}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.deleteAuthor').attr('data-id', data.id);
                $('#authorFirstName').text(data.first_name);
                $('#authorLastName').text(data.last_name);
                $('#authorBirthday').text(new Date(data.birthday).toISOString().split('T')[0]);
                $('#authorGender').text(data.gender);
                $('#authorPlaceOfBirth').text(data.place_of_birth);
                $('#authorBiography').text(data.biography);

                let html = '<table class="table table-bordered"><thead><tr>';
                html += `
                    <th>Description</th>
                    <th>Format</th>
                    <th>ISBN</th>
                    <th>Number of Pages</th>
                    <th>Release Date</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr></thead><tbody>`;

                data.books.forEach(book => {
                    html += `
                        <tr>
                            <td>${book.description}</td>
                            <td>${book.format}</td>
                            <td>${book.isbn}</td>
                            <td>${book.number_of_pages}</td>
                            <td>${new Date(book.release_date).toISOString().split('T')[0]}</td>
                            <td>${book.title}</td>
                            <td><button class="btn btn-danger deleteBook" data-id="${book.id}">Delete Book</button></td>
                        </tr>
                    `;
                });

                if (data.books.length == 0) {
                    $('.deleteAuthor').show();
                } else {
                    $('.deleteAuthor').hide();
                }

                html += '</tbody></table>';
                $('#authorBooks').html(html);

                $('#loader').hide();
                $('#authorModal').modal('show');
            },
            error: function (error) {
                console.error('Error fetching author details:', error);
                $('#loader').hide();
            }
        });
    });

    $('.deleteAuthor').on('click', function () {
        const authorId = $(this).data('id');
        $.ajax({
            url: `/authors/${authorId}`,
            method: 'DELETE',
            dataType: 'json',
            success: function (data) {
                $('#authorModal').modal('hide');
                location.reload();
                toastr.options = {
                    'timeOut': 2000,
                    'closeButton': true,
                    'progressBar': true,
                    "positionClass": "toast-top-center",
                };
                toastr.success("Author Deleted Successfully");
            },
            error: function (error) {
                console.error('Error deleting author:', error);
            }
        });
    });

    $(document).on('click', '.deleteBook', function () {
        const bookId = $(this).data('id');
        const url = "/delete-books";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: {
                bookID: bookId,
            },
            success: function (data) {
                toastr.options = {
                    'timeOut': 2000,
                    'closeButton': true,
                    'progressBar': true,
                    'positionClass': 'toast-top-center',
                };
                toastr.success("Book Deleted Successfully");
                $('#authorModal').modal('hide');
            },
            error: function (error) {
                console.error('Error deleting book:', error);
                toastr.options = {
                    'timeOut': 2000,
                    'closeButton': true,
                    'progressBar': true,
                    'positionClass': 'toast-top-center',
                };
                toastr.error("Error deleting book");
            }
        });
    });
});
