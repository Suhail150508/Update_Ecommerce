@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bundled Products</h1>
    <a href="{{ url('bundles/create') }}" class="btn btn-primary mb-3">Create New Bundle</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Bundle Name</th>
                <th>Products</th>
                {{-- <th>Bundle Price</th> --}}
                <th>Discount (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bundles as $bundle)
            <tr>
                <td>{{ $bundle->id }}</td>
                <td>{{ $bundle->name }}</td>
                <td>
                    @foreach ($bundle->products as $product)
                    {{-- @dd($product->name,number_format($product->new_price, 2)); --}}
                        {{ $product->name }} ({{ number_format($product->new_price, 2) }})<br>
                    @endforeach
                </td>
                <td>{{ number_format($bundle->price,0) ?? 0 }}%</td>
                {{-- <td>{{ $bundle->discount->discount_percentage ?? 0 }}%</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
