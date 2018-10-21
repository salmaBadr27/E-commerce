<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Cart;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{

  //take quantity the user enter it from show-cart view and product id
  //select product id that match the selected item and put them in array
  //then use add() function to add this info
  public function add_to_cart(Request $request){

    $qty=$request->qty;
    $product_id=$request->product_id;
    $product_info=DB::table('product')
                  ->where('product_id',$product_id)
                  ->first();
    $data['qty']=$qty;
    $data['id']=$product_info->product_id;
    $data['name']=$product_info->product_name;
    $data['price']=$product_info->product_price;
    $data['options']['image']=$product_info->product_image;
    Cart::add($data);
    return Redirect::to('/show-cart');

  }
  public function show_cart()
  {

    //return view of home layout with published category
     $all_published_category=DB::table('categories')
                            ->where('publication_status',1)
                            ->get();
       $manage_published_category=view('pages.add_to_cart')
             ->with('all_published_category',$all_published_category);
     return view('layout')
             ->with('pages.add_to_cart',$manage_published_category);                      
 
  }
  public function delete_to_cart($rowId)
    {
      //delete row of cart cntent by id
    	Cart::update($rowId,0);
    	return Redirect::to('/show-cart');
    }
    
    public function update_cart(Request $request)
    {
      //update row content by id with new quantity
       $qty=$request->qty;
       $rowId=$request->rowId;
       Cart::update($rowId,$qty);
      return Redirect::to('/show-cart');
    }
   
}
