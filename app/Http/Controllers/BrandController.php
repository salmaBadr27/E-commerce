<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  App\Http\Requests;
use DB;
use Session;
session_start();

class BrandController extends Controller
{
    public function index (){

  return view('admin.add-brand');

    }
    public function all_brand (){

        $all_brand = DB::table('brands')->get(); 
        $manage_brand = view('admin.all-brand')
        ->with('all_brand',$all_brand);
        return view ('admin_layout')->with('admin.all-brand',$manage_brand);
          }
          public function save_brand (Request $request){

       $data = array();
       $data['brand_id'] = $request->brand_id; 
       $data['brand_name'] = $request->brand_name;
       $data['brand_description'] = $request->brand_description;
       $data['publication_status'] = $request->publication_status;
       DB::table('brands')->insert($data);
       Session::put('message','brand added succefully');
       return Redirect::to('/add-brand');
              }
              public function unactive_brand ($brand_id) {

                DB::table('brands')
                ->where('brand_id',$brand_id)
                ->update(['publication_status' => 0]);
                Session::put('message','brand unactivated');
                return Redirect::to('/all-brand');
      
                }
      
                //activate status of brand
                public function active_brand ($brand_id) {
      
                  DB::table('brands')
                  ->where('brand_id',$brand_id)
                  ->update(['publication_status' =>1]);
                  Session::put('message','brand activated');
                  return Redirect::to('/all-brand');
        
                  }
                  //edit brand by id 
                  public function edit_brand ($brand_id) {
      
                      $single_brand= DB::table('brands')
                      ->where('brand_id',$brand_id)
                      ->first();
                      $edited_brand = view('admin.edit-brand')
                      ->with('single_brand', $single_brand );
                      return view ('admin_layout') 
                      ->with('admin.edit-brand',$edited_brand);
                     
            
                      }
                       //update brand by id 
                      public function update_brand (Request $request,$brand_id) {
      
                          $data = array();
                          $data['brand_name'] = $request->brand_name;
                          $data['brand_description'] = $request->brand_description;
                          DB::table('brands')
                          ->where('brand_id',$brand_id)
                          ->update($data);
                          Session::put('message','brand updated succefully');
                           return Redirect::to('/all-brand');
                          }
                             //update brand by id 
                      public function delete_brand ($brand_id) {
                        DB::table('brands')
                        ->where('brand_id',$brand_id)
                        ->delete();
                        Session::put('message','brand deleted succefully');
                         return Redirect::to('/all-brand');
                        }
}
