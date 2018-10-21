<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;
session_start();

class SuperAdminController extends Controller
{
  public function logout() {
 
    Session::flush(); //destroy session of user {delete user name and id from session}
  // Session::put('admin_name',null);
  // Session::put('admin_id',null);
 
  return Redirect::to('/admin');

  }
  public function index() {
    $this->AdminAuthCheck();  //befor return to dashboard view this function authenticate if user exist in session variable
    return view('admin.dashboard');
    
  
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
