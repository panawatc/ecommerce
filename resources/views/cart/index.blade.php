@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <h1>Shopping Cart</h1>
    
    @if(count($cartItems) > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" width="50" alt="{{ $item['product']->name }}" class="me-3">
                                    @endif
                                    {{ $item['product']->name }}
                                </div>
                            </td>
                            <td>${{ number_format($item['product']->price, 2) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['product']->price * $item['quantity'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>.
        </div>
    @endif
@endsection