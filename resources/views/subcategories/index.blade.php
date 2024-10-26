@extends('layouts.app')

@section('content')

 <!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h2>All Sub_Categories</h2>
    <div style="width: 100%">
        <a href="{{ route('subcategories.create') }}" class="btn btn-success" style="float: right">Add New SubCategory</a>
    </div>
    @if($subcategories->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:8%;font-size:1rem">SL</th>
                    <th style="width:20%;font-size:1rem">Name</th>
                    <th style="width:20%;font-size:1rem">Image</th>
                    <th style="width:20%;font-size:1rem">Category</th>
                    <th style="width:20%;font-size:1rem">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subcategories as $index=> $subcategory)

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>
                            <div class="avatar-group-item">
                                <a href="javascript: void(0);" class="d-inline-block">
                                    <div class="project">
                                        @if($subcategory->image)
                                        <img width="60" height="60" src="{{asset($subcategory->image) }}" alt="" class="rounded-circle ">
                                        @else
                                            <p>No image</p>
                                        @endif                                                                    
                                    </div>

                                </a>
                            </div>

                        </td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>
                            <a href="{{ route('subcategories.edit', $subcategory) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('subcategories.destroy', $subcategory) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>                                                                                    

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center" style="margin-top: 5rem">
            {{ $subcategories->links('pagination::bootstrap-4') }}
        </div>
    @else
        <h2 style="text-align:center;margin-top:9rem">There is no Sub_Category..</p>
    @endif
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
            form.action = "{{ route('confirm.delete', $subcategory->id) }}";
            form.method = 'POST';
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
</script>
@endif



@endsection


