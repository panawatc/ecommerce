<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
{
    $user = auth()->user();
    $orders = Order::where('email', $user->email)
             ->orderBy('created_at', 'desc')
             ->paginate(10);
             
    return view('orders.index', compact('orders'));
}

public function show(Order $order)
{
    // Ensure user can only see their own orders
    if (auth()->user()->email !== $order->email && !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized action.');
    }
    
    $order->load('items.product');
    
    return view('orders.show', compact('order'));
}
    public function create()
    {
        $cartItems = session()->get('cart', []);
        
        if (count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['product']->price * $item['quantity'];
        }
        
        return view('orders.checkout', compact('cartItems', 'total'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
        ]);
        
        $cartItems = session()->get('cart', []);
        
        if (count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['product']->price * $item['quantity'];
        }
        
        DB::beginTransaction();
        
        try {
            // Create the order
            $order = Order::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['zip'],
                'phone' => $validated['phone'],
                'total' => $total,
                'status' => 'pending'
            ]);
            
            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity']
                ]);
                
                // Update product stock
                $product = $item['product'];
                $product->stock -= $item['quantity'];
                $product->save();
            }
            
            DB::commit();
            
            // Clear the cart
            session()->forget('cart');
            
            return view('orders.confirmation', compact('order'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}