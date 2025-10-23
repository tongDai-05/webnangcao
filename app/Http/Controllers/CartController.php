<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    protected function getOrCreateCart()
    {
        if (Auth::check()) {
            $sessionCart = Cart::where('session_id', session()->getId())->first();
            if ($sessionCart) {
                $sessionCart->user_id = Auth::id();
                $sessionCart->session_id = null;
                $sessionCart->save();
            }
            return Auth::user()->carts()->firstOrCreate([]);
        }
        
        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId], ['session_id' => $sessionId]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('book')->get();

        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::find($validated['book_id']);

        if ($validated['quantity'] > $book->quantity) {
            return redirect()->back()->with('error', 'Sách "' . $book->title . '" chỉ còn ' . $book->quantity . ' cuốn trong kho.');
        }

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->where('book_id', $book->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            if ($newQuantity > $book->quantity) {
                 return redirect()->back()->with('error', 'Tổng số lượng yêu cầu (' . $newQuantity . ') vượt quá tồn kho.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
            $message = 'Đã cập nhật số lượng sách "' . $book->title . '" trong giỏ hàng!';
        } else {
            $cart->items()->create([
                'book_id' => $book->id,
                'quantity' => $validated['quantity'],
                'price' => $book->price,
            ]);
            $message = 'Đã thêm sách "' . $book->title . '" vào giỏ hàng!';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }

    public function update(Request $request, CartItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $book = $item->book;
        if ($validated['quantity'] > $book->quantity) {
             return redirect()->route('cart.index')->with('error', 'Số lượng sách "' . $book->title . '" vượt quá tồn kho cho phép.');
        }

        $item->update(['quantity' => $validated['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng sách "' . $book->title . '" thành công.');
    }
    public function destroy(CartItem $item)
    {
        $bookTitle = $item->book->title;
        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa sách "' . $bookTitle . '" khỏi giỏ hàng.');
    }
}