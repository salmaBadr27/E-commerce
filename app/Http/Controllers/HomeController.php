<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  App\Http\Requests;
use DB;
use Session;
session_start();


class HomeController extends Controller
{
    public function index()
{
  $all_product = DB::table('product')
  ->join('categories','product.category_id','=','categories.category_id')
  ->join('brands','product.brand_id','=','brands.brand_id')
  ->select('product.*','categories.category_name','brands.brand_name')
  ->where('product.publication_status',1)
  ->limit(9)
  ->get(); 
  $manage_product = view('pages.home_content')
  ->with('all_product',$all_product);
  return view ('layout')->with('pages.home_content',$manage_product);
  }
  public function show_product_by_category($category_id)
  {
     $product_by_category=DB::table('product')
                     ->join('categories','product.category_id','=','categories.category_id')
                     ->select('product.*','categories.category_name')
                     ->where('categories.category_id',$category_id)
                     ->where('product.publication_status',1)
                     ->limit(18)
                     ->get();
       $manage_product_by_category=view('pages.category_by_product')
               ->with('product_by_category',$product_by_category);
       return view('layout')
               ->with('pages.category_by_product',$manage_product_by_category); 
 
  }
  public function show_product_by_brand($brand_id)
  {
     $products_by_brand =DB::table('product')
                     ->join('brands','product.brand_id','=','brands.brand_id')
                     ->select('product.*','brands.brand_name')
                     ->where('brands.brand_id',$brand_id)
                     ->where('product.publication_status',1)
                     ->limit(18)
                     ->get();
       $manage_product_by_brand=view('pages.brand_by_product')
               ->with('products_by_brand',$products_by_brand);
       return view('layout')
               ->with('pages.brand_by_product',$manage_product_by_brand); 
 
  }
  public function show_product_by_id($product_id)
  {
      $product_by_details=DB::table('product')
                     ->join('categories','product.category_id','=','categories.category_id')
                     ->join('brands','product.brand_id','=','brands.brand_id')
                     ->select('product.*','categories.category_name','brands.brand_name')
                     ->where('product.product_id',$product_id)
                     ->where('product.publication_status', 1)
                     ->first();
       $manage_product_by_details=view('pages.product_details')
               ->with('product_by_details',$product_by_details);
       return view('layout')
               ->with('pages.product_details',$manage_product_by_details); 
  }
}
