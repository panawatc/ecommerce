@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            @else
                <div class="bg-light text-center py-5">No Image</div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">Category: {{ $product->category->name }}</p>
            <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>
            <p>Stock: {{ $product->stock }}</p>
            
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                </div>
                <button type="submit" class="btn btn-lg btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
@endsection