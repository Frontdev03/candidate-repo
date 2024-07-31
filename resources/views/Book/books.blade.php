<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Books Dashboard') }}
            </h2>
            <x-primary-button id="openModal">Add Book</x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <input type="hidden" id="bearer-token" data-bearer-token="{{ $bearerToken }}">
                                <th scope="col">#</th>
                                <th scope="col">Book Title</th>
                                <th scope="col">Book Release Date</th>
                                <th scope="col">Book ISBN</th>
                                <th scope="col">Book Format</th>
                                <th scope="col">Book Number Of Pages</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books['items'] as $key => $book)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>{{ $book['title']}}</td>
                                <td>{{ (new DateTime($book['release_date']))->format('Y-m-d') }}</td>
                                <td>{{ $book['isbn']}}</td>
                                <td>{{ $book['format']}}</td>
                                <td>{{ $book['number_of_pages']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addBookForm">
                        <!-- Dropdown for Authors -->
                        <div class="form-group">
                            <label for="author">Author</label>
                            <select id="author" name="author" class="form-control">
                                <!-- Options will be populated here -->
                            </select>
                        </div>

                        <!-- Book Title -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <!-- Release Date -->
                        <div class="form-group">
                            <label for="release_date">Release Date</label>
                            <input type="date" id="release_date" name="release_date" class="form-control" required>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                        </div>

                        <!-- ISBN -->
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" id="isbn" name="isbn" class="form-control">
                        </div>

                        <!-- Format -->
                        <div class="form-group">
                            <label for="format">Format</label>
                            <input type="text" id="format" name="format" class="form-control">
                        </div>

                        <!-- Number of Pages -->
                        <div class="form-group">
                            <label for="number_of_pages">Number of Pages</label>
                            <input type="number" id="number_of_pages" name="number_of_pages" class="form-control">
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/book.js') }}"></script>
</x-app-layout>