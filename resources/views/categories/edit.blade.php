@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-sm">
            <h2 class="text-center mb-4 text-primary">Edit Category</h2>

            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Category Name -->
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name', $category->name) }}" required placeholder="Enter category name">
                </div>

                <!-- Category Image Upload -->
                <div class="form-group mb-4">
                    <label for="image" class="font-weight-bold">Category Image</label>
                    <input type="file" class="form-control-file" name="image">
                    @if($category->image)
                        <div class="mt-3">
                            <img width="60" height="60" src="{{ asset($category->image) }}" alt="Category Image" class="rounded-circle shadow-sm">
                        </div>
                    @endif
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-lg btn-success px-5 mr-2">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-lg btn-secondary px-5">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
