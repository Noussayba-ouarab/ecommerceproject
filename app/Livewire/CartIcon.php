<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartIcon extends Component
{


    public $cartCount;
    public $sum;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cart = Session::get('cart', []);
        Session::put('cart', $cart);
        $sum = 1;
        foreach ($cart as $item) {
            // Access the total price of each item and add it to the total
            $sum = intval($item['item']);
        }
        
        Session::put('cart', $cart);
        Session::put('sum', $sum);
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
