<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Author Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Place Of Birth</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authorsData['items'] as $key => $author)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>{{ $author['first_name']}}</td>
                                <td>{{ $author['last_name']}}</td>
                                <td>{{ (new DateTime($author['birthday']))->format('Y-m-d') }}</td>
                                <td>{{ $author['gender']}}</td>
                                <td>{{ $author['place_of_birth']}}</td>
                                <td>
                                    <button type="button" class="viewAuthor btn btn-primary" title="View" data-id="{{ $author['id'] }}">View</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="authorModal" tabindex="-1" aria-labelledby="authorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 813px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="authorModalLabel">Author Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>First Name:</strong> <span id="authorFirstName"></span></p>
                    <p><strong>Last Name:</strong> <span id="authorLastName"></span></p>
                    <p><strong>Birthday:</strong> <span id="authorBirthday"></span></p>
                    <p><strong>Gender:</strong> <span id="authorGender"></span></p>
                    <p><strong>Place of Birth:</strong> <span id="authorPlaceOfBirth"></span></p>
                    <p><strong>Biography:</strong> <span id="authorBiography"></span></p>
                    <p><strong>Books:</strong> <span id="authorBooks"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="deleteAuthor btn btn-danger" title="Delete" data-id="">Delete Author</button>
                    <button type="button" class="btn btn-secondary" id="closeModal" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader -->
    <div id="loader" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); display: none;">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>


    <script src="{{ asset('js/author.js') }}"></script>
</x-app-layout>