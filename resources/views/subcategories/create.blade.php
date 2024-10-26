@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-sm">
            <h2 class="text-center mb-4 text-primary">Add Subcategory</h2>

            <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Subcategory Name -->
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Subcategory Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" placeholder="Enter subcategory name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div class="form-group mb-4">
                    <label for="category" class="font-weight-bold">Category <span class="text-danger">*</span></label>
                    <select class="form-control form-control-lg @error('category_id') is-invalid @enderror" id="category" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="form-group mb-4">
                    <label for="image" class="font-weight-bold">Subcategory Image</label>
                    <input type="file" class="form-control-file" name="image">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-lg btn-success px-5">Add Subcategory</button>
                </div>
            </form>
        </div>
    </div>
@endsection
