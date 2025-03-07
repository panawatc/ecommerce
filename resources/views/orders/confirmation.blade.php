@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <div class="text-center">
        <h1>Thank You for Your Order!</h1>
        <p class="lead">Your order has been placed successfully.</p>
        <p>Order Number: <strong>{{ $order->id }}</strong></p>
        <p>We've sent a confirmation email to <strong>{{ $order->email }}</strong>.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
@endsection