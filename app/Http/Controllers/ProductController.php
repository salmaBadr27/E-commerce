<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  App\Http\Requests;
use DB;
use Session;
session_start();

class ProductController extends Controller
{
    public function index (){

        return view('admin.add-product');
      
          }
          public function save_product (Request $request){

            $data = array();
            $data['product_name'] = $request->product_name;
            $data['category_id'] = $request->category_id;
            $data['brand_id'] = $request->brand_id;
            $data['product_size'] = $request->product_size;
            $data['product_color'] = $request->product_color;
            $data['product_price'] = $request->product_price;
            $data['product_short_description'] = $request->product_short_description;
            $data['product_long_description'] = $request->product_long_description;
            $data['publication_status'] = $request->publication_status;
 
            //upload product image
           $image = $request->file('product_image'); //return true or false
            if($image){
            $image_name = str_random(20); //generate rrandom image name
            $ext = strtolower($image->getClientOriginalExtension()); //get image extension
            $upload_path = 'backend/img/products/'; //distenation tostore image
            $image_full_name =  $image_name.'.'.$ext; //image full name
            $image_url =  $upload_path.$image_full_name ; //image url
            $moved_to_dist = $request->file('product_image')->move($upload_path , $image_full_name); //return true if moved to dis
            if($moved_to_dist){
                 $data['product_image'] =  $image_url; 
                DB::table('product')->insert($data);
                Session::put('message','product added succefully');
                return Redirect::to('/add-product');
            }
            }
            $data['product_image'] = '';
                DB::table('product')->insert($data);
                Session::put('message','product added succefully without image');
                return Redirect::to('/add-product');
        }
        public function all_product (){
            
            $all_product = DB::table('product')
            ->join('categories','product.category_id','=','categories.category_id')
            ->join('brands','product.brand_id','=','brands.brand_id')
            ->select('product.*','categories.category_name','brands.brand_name')
            ->get(); 
            $manage_product = view('admin.all-product')
            ->with('all_product',$all_product);
            return view ('admin_layout')->with('admin.all-product',$manage_product);
              }
              
              public function unactive_product ($product_id) {

                DB::table('product')
                ->where('product_id',$product_id)
                ->update(['publication_status' => 0]);
                Session::put('message','product unactivated');
                return Redirect::to('/all-product');

                }
      
                //activate status of product
                public function active_product ($product_id) {
      
                  DB::table('product')
                  ->where('product_id', $product_id)
                  ->update(['publication_status' => 1]);
                  Session::put('message','product activated');
                  return Redirect::to('/all-product');
                echo $product_id;
                  }

                  public function delete_product ($product_id) {
                    DB::table('product')
                    ->where('product_id',$product_id)
                    ->delete();
                    Session::put('message','product deleted succefully');
                     return Redirect::to('/all-product');
                    }
                    public function edit_product ($product_id) {
      
                        $single_product= DB::table('product')
                        ->join('categories','product.category_id','=','categories.category_id')
                        ->join('brands','product.brand_id','=','brands.brand_id')
                        ->select('product.*','categories.category_name','brands.brand_name')
                        ->where('product_id',$product_id)
                        ->first();
                        $edited_product = view('admin.edit-product')
                        ->with('single_product', $single_product );
                        return view ('admin_layout') 
                        ->with('admin.edit-product',$edited_product);
                       
              
                        }
                          public function update_product(Request $request,$product_id)
    {
         $data=array();
         $data['product_name']=$request->product_name;
         $data['category_id']=$request->category_id;
         $data['brand_id']=$request->brand_id;
         $data['product_short_description']=$request->product_short_description;
         $data['product_long_description']=$request->product_long_description;
         $data['product_price']=$request->product_price;
         $data['product_size']=$request->product_size;
         $data['product_color']=$request->product_color;
        $image=$request->file('product_image');
    if ($image) {
       $image_name=str_random(20);
       $ext=strtolower($image->getClientOriginalExtension());
       $image_full_name=$image_name.'.'.$ext;
       $upload_path='backend/img/products/';
       $image_url=$upload_path.$image_full_name;
       $success=$image->move($upload_path,$image_full_name);
       if ($success) {
         $data['product_image']=$image_url;
            DB::table('product')
            ->where('product_id',$product_id)
            ->update($data);
            Session::put('message','Product updated successfully!!');
            return Redirect::to('/all-product');
       }
    }
    DB::table('product')
    ->where('product_id',$product_id)
    ->update($data);
    Session::put('message','Product updated successfully!!');
        return Redirect::to('/all-product');
    }

                      


}
