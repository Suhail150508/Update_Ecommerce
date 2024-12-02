@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-5 shadow-lg border-0 rounded-3">
            <h2 class="text-center mb-4 text-primary fw-bold">Add Bundle</h2>
        
            <form action="{{ route('bundle.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
        
                <!-- Bundle Name -->
                <div class="form-group mb-4">
                    <label for="name" class="fw-semibold">Bundle Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Enter bundle name" 
                           value="{{ old('name') }}">
        
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <!-- Select Products -->
                <div class="form-group mb-4">
                    <label class="fw-semibold">Select Products <span class="text-danger">*</span></label>
                    <div class="border rounded p-3">
                        @foreach($products as $product)
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="product_ids[]" 
                                       value="{{ $product->id }}" 
                                       id="product_{{ $product->id }}" 
                                       @if(is_array(old('product_ids')) && in_array($product->id, old('product_ids'))) checked @endif>
                                <label class="form-check-label" for="product_{{ $product->id }}">
                                    {{ $product->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
        
                    @error('product_ids')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
        
                <!-- Discount Type -->
                <div class="form-group mb-4">
                    <label for="discount_type" class="fw-semibold">Discount Type <span class="text-danger">*</span></label>
                    <select name="discount_type" 
                            id="discount_type" 
                            class="form-control @error('discount_type') is-invalid @enderror">
                        <option value="">Select Discount Type</option>
                        <option value="Fixed" @if(old('discount_type') === 'Fixed') selected @endif>Fixed</option>
                        <option value="Percentage" @if(old('discount_type') === 'Percentage') selected @endif>Percentage</option>
                    </select>
        
                    @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <!-- Price -->
                <div class="form-group mb-4">
                    <label for="price" class="fw-semibold">Price <span class="text-danger">*</span></label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           class="form-control @error('price') is-invalid @enderror" 
                           placeholder="Enter price" 
                           value="{{ old('price') }}" 
                           min="0" step="0.01">
        
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        <i class="bi bi-plus-circle me-2"></i>Add Bundle
                    </button>
                </div>
            </form>
        </div>
        
    </div>
@endsection
