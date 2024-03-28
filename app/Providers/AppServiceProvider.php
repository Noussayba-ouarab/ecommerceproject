<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //parent::boot();

    // Add a listener to execute before every request
    // $this->app->booted(function () {
    //     // Check if the user is authenticated
    //     if (Auth::check()) {
    //         // Find the authenticated user
    //         $user = Auth::user();

    //         // Retrieve the cart from the session
    //         $cart = Session::get('cart', []);

    //         // Calculate the sum of items in the cart
    //         $cartData = collect($cart)->pluck('item')->toArray();
    //         $values = array_map('intval', $cartData);
    //         $sum = array_sum($values);

    //         // Store the sum in the session
    //         Session::put('sum', $sum);
    //     }
    // });
    }
}
