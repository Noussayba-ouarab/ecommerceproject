<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Payment;
use App\Models\orders;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\categories;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller

{
    public function pay(): View
    {
        return view('payment');
    }
    /**
     * insert product
     *
     * @param Request $request
     * @return void
     */
    public function addproduct(Request $request)
    {
        $data = new Product();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->size = $request->size;
        $data->prix = $request->prix;
        $data->type = $request->type;

        $image = $request->image;
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('produits', $imagename);
            $data->image = $imagename;
        }
        $data->save();
        return redirect("/home");
    }
    /**
     * afficher des produits pour les femmes
     *
     * @return View
     */
    public function produitfemme(): View
    {
        $products = Product::where('type', 1)->with('categories')->get();
        return view("produitfemme", ['products' => $products]);
    }
    /**
     * afficher des produits pour les hommes
     *
     * @return View
     */
    public function produithomme(): View
    {
        $products = Product::where('type', 3)->with('categories')->get();
        return view("produithomme", ['products' => $products]);
    }
    /**
     * afficher des produits pour les enfants
     *
     * @return View
     */
    public function produitenfant(): View
    {
        $products = Product::where('type', 4)->with('categories')->get();
        return view("produitenfant", ['products' => $products]);
    }
    /**
     * afficher tous les produits
     *
     * @return View
     */
    public function index(): View
    {

        $products = Product::paginate(10);
        $user = Auth::user();
        if ($user) {
            $order = Orders::where($user->id);
            return view('welcome', ['products' => $products, 'order' => $order]);
        }
        return view('welcome', ['products' => $products]);
    }
    /**
     * afficher details produit
     *@param [int] $id 
     * @return View
     */
    public function afficherpro($id): View
    {
        $products = Product::find($id);
        return view('afficherpro', ['products' => $products]);
    }
    /**
     * ajouter l order dans un panier
     *
     * @param Request $request
     * @param [int] $id
     * @return void
     */
    public function addcommande(Request $request, $id)
    {
        $user = Auth::user();
        $produit = Product::find($id);
        $payment = Payment::where('user_id', $user->id)->first();
        // If a Commande doesn't exist for the user, create a new one
        if (!$payment) {
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->TransactionId = 0;
            $payment->merchantToken = '';
            $payment->paymentmethod = '';
        }
        $order = new orders();
        $order->user_id = $user->id;
        $order->quantity = $request->input('quantite');
        $order->total_price = $request->input('prix');
        $order->product_id = $id;
        $order->payment_id = $payment->id;
        $order->save();
        $name = $produit->name;
        $order = [
            'product_id' => $id,
            'user_id' => $user->id, 'name' => $name,
            'item' => $request->input('item'),
            'quantity' => $request->input('quantite'),
            'total_price' => $request->input('prix'),
        ];
        $cart = Session::get('cart', []);
        $cart[] = $order;
        Session::put('cart', $cart);

        return redirect()->route("afficherpro", ['id' => $id]);
    }
    /**
     * afficher les produits choisi
     *
     * @return View
     */
    public function afficheritems(): View
    {
        $cart = Session::get('cart');
        $sum = 0;
        foreach ($cart as $item) {
            // Access the total price of each item and add it to the total
            $sum = intval($item['item']);
            $c[] = $sum;
        }
        Session::put('cart', $cart);
        Session::put('sum', $sum);
        return view('afficheritems', ['cart', $cart]);
    }
    /**
     * delete product from session
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $cart = Session::get('cart');
        // Search for the item in the cart by its product ID
        foreach ($cart as $index => $item) {
            if ($item['product_id'] === $id) {
                // Remove the item from the cart array
                unset($cart[$index]);
                // Reset array keys to prevent gaps in the array
                $cart = array_values($cart);
                // Store the updated cart data back into the session
                session()->put('cart', $cart);
                return redirect()->back(); // Item deleted successfully
            }
        }
        return false;
    }
    public function perform()
    {
        Session::flush();
        
        Auth::logout();

        return redirect()->route('/');
    }
}
