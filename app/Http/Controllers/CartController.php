<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = 0;
        
        foreach ($cartItems as $item) {
            $total += $item['product']->price * $item['quantity'];
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        // Get the current cart
        $cart = session()->get('cart', []);
        
        // Check if product already exists in cart
        $found = false;
        foreach ($cart as $key => $item) {
            if ($item['product']->id === $product->id) {
                $cart[$key]['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        // If product not in cart, add it
        if (!$found) {
            $cart[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
        
        // Update the cart in session
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        
        // Find and remove the product
        foreach ($cart as $key => $item) {
            if ($item['product']->id === $product->id) {
                unset($cart[$key]);
                break;
            }
        }
        
        // Reindex the array
        $cart = array_values($cart);
        
        // Update the cart in session
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }
}