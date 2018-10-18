<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  App\Http\Requests;
use DB;
use Session;
session_start();
class CategoryController extends Controller
{
   public function index () {
    $this->AdminAuthCheck();
 return view ('admin.add-category');

   }
   public function all_category () {
    $this->AdminAuthCheck();
       $all_category = DB::table('categories')->get(); // get all record from DB table categories
       $manage_category = view('admin.all-category') // manage view of all category by adding the data from DB to it
       ->with('all_category',$all_category);
      return view ('admin_layout')->with('admin.all-category',$manage_category); // retrun admin layout with these category
   
      }


      // get values of input field and assign 
       //it to array which indexs of it is column name of category table and $request refer to post request
       //then show flash message tell the user that data inserted succefully
       // and redirect him to add form
      public function save_category (Request $request) {
       $data = array();
       $data['category_id'] = $request->category_id; 
       $data['category_name'] = $request->category_name;
       $data['category_description'] = $request->category_description;
       $data['publication_status'] = $request->publication_status;
       DB::table('categories')->insert($data);
       Session::put('message','category added succefully');
       return Redirect::to('/add-category');
          }


          // deactivate status of category
          public function unactive_category ($category_id) {

          DB::table('categories')
          ->where('category_id',$category_id)
          ->update(['publication_status' => 0]);
          Session::put('message','category unactivated');
          return Redirect::to('/all-category');

          }

          //activate status of category
          public function active_category ($category_id) {

            DB::table('categories')
            ->where('category_id',$category_id)
            ->update(['publication_status' =>1]);
            Session::put('message','category activated');
            return Redirect::to('/all-category');
  
            }
            //edit category by id 
            public function edit_category ($category_id) {

                $single_category= DB::table('categories')
                ->where('category_id',$category_id)
                ->first();
                $edited_category = view('admin.edit-category')
                ->with('single_category', $single_category );
                return view ('admin_layout') 
                ->with('admin.edit-category',$edited_category);
               
      
                }
                 //update category by id 
                public function update_category (Request $request,$category_id) {

                    $data = array();
                    $data['category_name'] = $request->category_name;
                    $data['category_description'] = $request->category_description;
                    DB::table('categories')
                    ->where('category_id',$category_id)
                    ->update($data);
                    Session::put('message','category updated succefully');
                     return Redirect::to('/all-category');
                    }
                       //update category by id 
                public function delete_category ($category_id) {
                  DB::table('categories')
                  ->where('category_id',$category_id)
                  ->delete();
                  Session::put('message','category deleted succefully');
                   return Redirect::to('/all-category');
                  }
                  public function AdminAuthCheck() {

                    $admin = Session::get('admin_id');
                    if($admin){
                      return;
                    }     else{
                      return Redirect::to('/admin')->send();
                    }
                   
                     }
}
