<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  App\Http\Requests;
use DB;
use Session;
session_start();

class SliderController extends Controller
{
    public function index (){

        return view('admin.add-slider');
      
          }
          public function all_slider (){

            $all_slider = DB::table('slider')->get(); 
            $manage_slider = view('admin.all-slider')
            ->with('all_slider',$all_slider);
            return view ('admin_layout')->with('admin.all-slider',$manage_slider);
              }

              public function unactive_slider ($slider_id) {

                DB::table('slider')
                ->where('slider_id',$slider_id)
                ->update(['publication_status' => 0]);
                Session::put('message','slider unactivated');
                return Redirect::to('/all-slider');
      
                }
      
                //activate status of slider
                public function active_slider ($slider_id) {
      
                  DB::table('slider')
                  ->where('slider_id',$slider_id)
                  ->update(['publication_status' =>1]);
                  Session::put('message','slider activated');
                  return Redirect::to('/all-slider');
        
                  }
                  public function save_slider (Request $request){

                    $data = array();
                    $data['slider_id'] = $request->slider_id; 
                    $data['publication_status'] = $request->publication_status;
                   
                    $image = $request->file('slider_image'); //return true or false
                    if($image){
                    $image_name = str_random(20); //generate rrandom image name
                    $ext = strtolower($image->getClientOriginalExtension()); //get image extension
                    $upload_path = 'backend/img/sliders/'; //distenation tostore image
                    $image_full_name =  $image_name.'.'.$ext; //image full name
                    $image_url =  $upload_path.$image_full_name ; //image url
                    $moved_to_dist = $request->file('slider_image')->move($upload_path , $image_full_name); //return true if moved to dis
                    if($moved_to_dist){
                        $data['slider_image'] =  $image_url; 
                    DB::table('slider')->insert($data);
                    Session::put('message','slider added succefully');
                    return Redirect::to('/add-slider');
                           }
                        }
                        $data['slider_image'] = '';
                        DB::table('slider')->insert($data);
                        Session::put('message','slider added succefully without image');
                        return Redirect::to('/add-slider');

}
public function delete_slider ($slider_id) {
    DB::table('slider')
    ->where('slider_id',$slider_id)
    ->delete();
    Session::put('message','slider deleted succefully');
     return Redirect::to('/all-slider');
    }
    
 
}