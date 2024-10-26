@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-sm">
            <h2 class="text-center mb-4 text-primary">Add Category</h2>

            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Category Name -->
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" placeholder="Enter category name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Category Image -->
                <div class="form-group mb-4">
                    <label for="image" class="font-weight-bold">Category Image</label>
                    <input type="file" class="form-control-file" name="image">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-lg btn-success px-5">Add Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection
