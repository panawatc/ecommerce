@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" width="50" alt="{{ $item->product->name ?? 'Product' }}" class="me-3">
                                            @endif
                                            {{ $item->product->name ?? 'Unknown Product' }}
                                        </div>
                                        </td>
                                   <td>${{ number_format($item->price, 2) }}</td>
                                   <td>{{ $item->quantity }}</td>
                                   <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                               </tr>
                               @endforeach
                           </tbody>
                           <tfoot>
                               <tr>
                                   <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                   <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                               </tr>
                           </tfoot>
                       </table>
                   </div>
               </div>
           </div>
       </div>
       
       <div class="col-md-4">
           <div class="card mb-4">
               <div class="card-header">
                   <h5>Order Details</h5>
               </div>
               <div class="card-body">
                   <p><strong>Order ID:</strong> {{ $order->id }}</p>
                   <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                   <p>
                       <strong>Status:</strong>
                       @if($order->status == 'pending')
                           <span class="badge bg-warning">Pending</span>
                       @elseif($order->status == 'processing')
                           <span class="badge bg-info">Processing</span>
                       @elseif($order->status == 'completed')
                           <span class="badge bg-success">Completed</span>
                       @elseif($order->status == 'cancelled')
                           <span class="badge bg-danger">Cancelled</span>
                       @endif
                   </p>
               </div>
           </div>
           
           <div class="card">
               <div class="card-header">
                   <h5>Shipping Information</h5>
               </div>
               <div class="card-body">
                   <p><strong>Name:</strong> {{ $order->name }}</p>
                   <p><strong>Email:</strong> {{ $order->email }}</p>
                   <p><strong>Phone:</strong> {{ $order->phone }}</p>
                   <p><strong>Address:</strong><br>
                   {{ $order->address }}<br>
                   {{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection