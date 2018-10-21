<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
class CheckoutController extends Controller
{
    public function login_check()
    {

    	return view('pages.login');
    }
    public function customer_login(Request $request)
    {
      $customer_email=$request->customer_email;
      $password=md5($request->password);
      $result=DB::table('customer')
              ->where('customer_email',$customer_email)
              ->where('password',$password)
              ->first();
             if ($result) {
               //if there is matches record put customer id in session
               Session::put('customer_id',$result->customer_id);
               return Redirect::to('/checkout');
             }else{

              //else return to login in to log
                return Redirect::to('/login-check');
             }
    }
  
    public function customer_registration(Request $request)
    {
      $data=array();
      $data['customer_name']=$request->customer_name;
      $data['customer_email']=$request->customer_email;
      $data['password']=md5($request->password);
      $data['mobile_number']=$request->mobile_number;
        $customer_id=DB::table('customer')
                     ->insertGetId($data);
               Session::put('customer_id',$customer_id);
               Session::put('customer_name',$request->customer_name);
               return Redirect('/checkout');      
    }
    public function checkout()
    {
      return view('pages.checkout');
    }
    public function save_shipping_details(Request $request)
    {
      $data=array();
      $data['shipping_email']=$request->shipping_email;
      $data['shipping_first_name']=$request->shipping_first_name;
      $data['shipping_last_name']=$request->shipping_last_name;
      $data['shipping_address']=$request->shipping_address;
      $data['shipping_mobile_number']=$request->shipping_mobile_number;
      $data['shipping_city']=$request->shipping_city;
        $shipping_id=DB::table('shipping')
                     ->insertGetId($data);
           Session::put('shipping_id',$shipping_id);
           return Redirect::to('/payment'); 
    }
   
    public function customer_logout()
    {
      //destroy session variable
      Session::flush();
      return Redirect::to('/');
    }
    public function payment()
    {
      return view('pages.payment');
    }
    public function order_place(Request $request)
    {
      $payment_gateway=$request->payment_method;
      // $total=Cart::total();
      // echo $total;
      
      $pdata=array();
      $pdata['payment_method']=$payment_gateway;
      $pdata['payment_status']='pending';
      $payment_id=DB::table('payments')
             ->insertGetId($pdata);
  
      $odata=array();
      $odata['customer_id']=Session::get('customer_id');
      $odata['shipping_id']=Session::get('shipping_id');
      $odata['payment_id']=$payment_id;
      $odata['order_total']=Cart::total();
      $odata['order_status']='pending';
      $order_id=DB::table('orders')
               ->insertGetId($odata);
  
     $contents=Cart::content();
     $oddata=array();
     foreach ($contents as  $content) 
     {
        $oddata['order_id']=$order_id;
        $oddata['product_id']=$content->id;
        $oddata['product_name']=$content->name;
        $oddata['product_price']=$content->price;
        $oddata['product_sales_quantity']=$content->qty;
        DB::table('orders_details')
            ->insert($oddata);
     }
     if ($payment_gateway=='handcash') {
          
      Cart::destroy();
     return view('pages.handcash');
    
   
}elseif ($payment_gateway=='cart') {

 echo "cart";
 
}elseif($payment_gateway=='paypal'){
    echo "paypal";
}else{
 echo "not selectd";
}

}
public function manage_order()
{
 
  $all_order_info=DB::table('orders')
                 ->join('customer','orders.customer_id','=','customer.customer_id')
                 ->select('orders.*','customer.customer_name')
                 ->get();
   $manage_order=view('admin.manage-order')
           ->with('all_order_info',$all_order_info);
   return view('admin_layout')
           ->with('admin.manage-order',$manage_order); 
}
public function view_order($order_id)
{
  $order_by_id=DB::table('orders')
          ->join('customer','orders.customer_id','=','customer.customer_id')
          ->join('orders_details','orders.order_id','=','orders_details.order_id')
          ->join('shipping','orders.shipping_id','=','shipping.shipping_id')
          ->select('orders.*','orders_details.*','shipping.*','customer.*')
          ->where('orders.order_id',$order_id)
          ->get();
   $view_order=view('admin.view-order')
           ->with('order_by_id',$order_by_id);
   return view('admin_layout')
           ->with('admin.view-order',$view_order); 
             
}
}