@extends('layouts.app')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container">
        <h2>Products</h2>
        <div style="width: 100%">
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3 " style="float: right">Add New Product</a>
        </div>
            @if($products->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-size:1rem">SL</th>
                            <th style="font-size:1rem">Name</th>
                            <th style="font-size:1rem">Image</th>
                            <th style="font-size:1rem">Description</th>
                            <th style="font-size:1rem">Subcategory</th>
                            <th style="font-size:1rem">Old Price</th>
                            <th style="font-size:1rem">New Price</th>
                            <th style="font-size:1rem">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @if(count($product->image) > 0)
                                        @foreach ($product->image as $image)
                                            @if($image)
                                                <img width="50" height="50" src="{{ asset('image/' . $image) }}" alt="img" style="border-radius:50%; object-fit: cover;">
                                            @endif
                                        @endforeach
                                    @else
                                        <p>No image</p>
                                    @endif
                                </td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->subcategory->name }}</td>
                                <td>{{ $product->old_price }}</td>
                                <td>{{ $product->new_price }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
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
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            @else
                <p>No products in this subcategory.</p>
            @endif
    </div>
@endsection
