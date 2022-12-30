<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;

use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Flash;


class CheckoutController extends Controller
{

    public function index(){
        $old_cartitems = Cart::where('users_id',Auth::id())->get();
        foreach($old_cartitems as $items){
            if(!Product::where('id', $items->product_id)->where('quantity','>=',$items->quantity)->exists()){
                $removeItem = Cart::where('users_id',Auth::id())->where('product_id',$items->product_id)->first();
                $removeItem -> delete();
            }
        }
        $cartitems = Cart::where('users_id',Auth::id())->get();
        return view('checkout.order',compact('cartitems'));
        
    }

    public function placeorder(Request $request){

        $order = new Order();
        $order->name = $request->input('name');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->trackingnumber = rand(111,9999);
       
       /* 
        $total=0;
        $cartitems_total = Cart::where('users_id',Auth::id())->get();
        foreach($cartitems_total as $prod){
            $total += $prod->product->price ;
        }
        $order->totalcost = $total;
        */
        $order-> save();

        $address = new Address();
        $address->housenumber = $request->input('house');
        $address->postalcode = $request->input('postal');
        $address->city = $request->input('city');
        $address->country = $request->input('country');
        $address->users_id = Auth::id();
        $address->save();


        $cartitems = Cart::where('users_id',Auth::id())->get();
        foreach($cartitems as $item){
            Purchase::create([
                'order_id'=>$order->id,
                'product_id'=>$item->product_id,
                'quantity'=>$item->quantity,
                'totalcost'=>$item->product->price,
            ]);

            $product = Product::where('id',$item->product_id)->first();
            $product->update();
            
        } 

        $total=0;
        $cartitems_total = Cart::where('users_id',Auth::id())->get();
        foreach($cartitems_total as $prod){
            $total += ($prod->product->price * $item->quantity) ;
        }
        $order->totalcost = $total;
        $order->users_id = Auth::id();
        $order-> save();

        $cartitems = Cart::where('users_id',Auth::id())->get();
        Cart::destroy($cartitems); 

        Flash::success('Order placed Successfully!');
        return redirect('/');
    }

    public function showorders(){

        $orders = Order::where('users_id',Auth::id())->get();
        return view('order.orders',compact('orders'));
    }

    public function vieworder($id){
        
        $address = Address::where('users_id',Auth::id())->get();
        $orders = Order::where('id',$id)->where('users_id',Auth::id())->first();
        return view('order.myorder',compact('orders','address'));

    }
    
}
