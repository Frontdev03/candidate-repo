$(document).ready(function() {
    const token = $('#bearer-token').data('bearer-token');
    $('#openModal').on('click', function() {
        $('#addBookModal').modal('show');
    });
    function fetchAuthors() {
        $.ajax({
            url: 'https://candidate-testing.api.royal-apps.io/api/v2/authors?orderBy=id&direction=ASC&limit=12&page=1',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            dataType: 'json',
            success: function(data) {
                var authorSelect = $('#author');
                authorSelect.empty(); 

                if (Array.isArray(data.items)) {
                    authorSelect.append('<option value="">Select an author</option>');
                    data.items.forEach(function(author) {
                        authorSelect.append('<option value="' + author.id + '">' + author.first_name + ' ' + author.last_name + '</option>');
                    });
                } else {
                    console.error('Unexpected response format:', data);
                    alert('Unexpected response format. Check the console for details.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch authors:', status, error);
                alert('Failed to fetch authors. Check the console for details.');
            }
        });
    }


    fetchAuthors();

    toastr.options = {
        'timeOut': 2000,
        'closeButton': true,
        'progressBar': true,
        'positionClass': 'toast-top-center',
    };

    $('#addBookForm').on('submit', function(event) {
        event.preventDefault();
        var bookData = {
            author: {
                id: parseInt($('#author').val(), 10)
            },
            title: $('#title').val(),
            release_date: $('#release_date').val(),
            description: $('#description').val(),
            isbn: $('#isbn').val(),
            format: $('#format').val(),
            number_of_pages: parseInt($('#number_of_pages').val(), 10),
        };

        $.ajax({
            url: 'https://candidate-testing.api.royal-apps.io/api/v2/books',
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            contentType: 'application/json',
            data: JSON.stringify(bookData),
            success: function() {
                toastr.success('Book added successfully');
                $('#addBookModal').modal('hide');
                location.reload();
            },
            error: function() {
                toastr.error('Failed to add book');
            }
        });
    });
});