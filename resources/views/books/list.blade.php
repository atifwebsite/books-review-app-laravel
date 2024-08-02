@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header  text-white">
                        Welcome, {{ Auth::user()->name }}
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('uploads/profile') . '/' . $user->image }}" class="img-fluid rounded-circle"
                                alt="">
                        </div>
                        <div class="h5 text-center">
                            <strong>{{ Auth::user()->name }}</strong>
                            <p class="h6 mt-2 text-muted">5 Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-lg mt-3">
                    <div class="card-header  text-white">
                        Navigation
                    </div>
                    <div class="card-body sidebar">
                        @include('layouts.sidebar')

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @include('layouts.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Books
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
                            <form action="" method="get">
                                <div class="d-flex">
                                    <input type="text" name="keyword" value="{{ Request::get('keyword') }}"
                                        class="form-control" placeholder="keywords">
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    <a href="{{ route('books.index') }}" class="btn btn-danger ms-2">Reset</a>
                                </div>
                            </form>
                        </div>
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            <tbody>
                                @if ($books)
                                    @foreach ($books as $row)
                                        <tr>
                                            <td>{{ $row->title }}</td>
                                            <td>{{ $row->author }}</td>
                                            <td>3.0 (3 Reviews)</td>
                                            <td>
                                                @if ($row->status == 1)
                                                    <a href="book_status_active_deactive/{{ $row->id }}"
                                                        class="text-success">Active</a>
                                                @else
                                                    <a href="book_status_active_deactive/{{ $row->id }}"
                                                        class="text-danger">DeActive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"><i
                                                        class="fa-regular fa-star"></i></a>
                                                <a href="{{ route('books.edit', $row->id) }}"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" onclick="Bookdelete({{ $row->id }});"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Books Not Found..</td>
                                    </tr>
                                @endif
                            </tbody>
                            </thead>
                        </table>
                        @if ($books->isNotEmpty())
                            {{ $books->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function Bookdelete(id) {
            if (confirm('Are you sure to delete this book ?')) {            
                $.ajax({
                    url: '{{ route('books.delete') }}',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function(response) {
                        window.location.href = '{{ route('books.index') }}';

                    }
                });
            }

        }
    </script>
@endsection
