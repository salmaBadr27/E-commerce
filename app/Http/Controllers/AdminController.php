<?php

namespace App\Http\Controllers;

use   Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  App\Http\Requests;
use DB;
use Session;
session_start();

class AdminController extends Controller
{
   public function index(){

    return view('admin.admin_login');

   }

   //action of submitting login 
   //take value of input field and select all from table admin if matches then make 
   //with these values and redirect him to dashboard view
   //else put session messages tell user is his username or password invalid
   //and redirect to login
   public function dashboard(Request $request){
   
    $admin_email = $request->admin_email;
    $admin_password = md5($request->admin_password);
    $result = DB::table('admin')
            ->where('admin_email',$admin_email)
            ->where('admin_password',$admin_password)
            ->first();
          

            if($result){

                Session::put('admin_name',$result->admin_name);
                Session::put('admin_id',$result->admin_id);
              return  Redirect::to('/dashboard');
            }
            else {
                Session::put('message','email or password not valid');
                return Redirect::to('/admin');
                
            }

   }
}
