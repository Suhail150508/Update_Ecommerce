@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-sm">
            <h2 class="text-center mb-4 text-primary">Edit Subcategory</h2>

            <form action="{{ route('subcategories.update', $subcategories->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Subcategory Name -->
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Subcategory Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name', $subcategories->name) }}" required>

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
                            <option value="{{ $category->id }}" {{ $subcategories->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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

                    @if($subcategories->image)
                        <div class="mt-3">
                            <img src="{{ asset($subcategories->image) }}" width="60" height="60" class="rounded-circle">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-lg btn-primary px-5">Update</button>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-lg btn-secondary ml-3 px-5">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
