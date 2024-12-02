@extends('layouts.app')

@section('content')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container">
        <h2>All Categories</h2>
        <div style="width: 100%">
            {{-- <a href="{{ route('categories.create') }}" class="btn btn-success" style="float: right">Add New Category</a> --}}
        </div>
        {{-- @if($categories->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:8%;font-size:1rem">SL</th>
                        <th style="width:30%;font-size:1rem">Name</th>
                        <th style="width:30%;font-size:1rem">Image</th>
                        <th style="width:15%;font-size:1rem">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="avatar-group-item">
                                    <a href="javascript: void(0);" class="d-inline-block">
                                        <div class="project">
                                            @if($category->image)
                                                <img width="60" height="60" src="{{ asset($category->image) }}" alt="" class="rounded-circle">
                                            @else
                                                <p>No image</p>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center" style="margin-top: 5rem">
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>

        @else
            <h2 style="text-align:center;margin-top:9rem">There is no Category..</h2>
        @endif --}}
    </div>


        <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('warning'))
    <script>
        Swal.fire({
            title: 'Warning!',
            text: "{{ session('warning') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = "{{ route('confirm_category.delete', $category->id) }}";
                form.method = 'POST';
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
    @endif
@endsection
