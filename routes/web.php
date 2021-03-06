<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//front end website routes
Route::get('/', 'HomeController@index');










// backend website routes
Route::get('/logout', 'SuperAdminController@logout');
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'SuperAdminController@index');
Route::post('/admin-dashboard', 'AdminController@dashboard');

//related category route
Route::get('/add-category', 'CategoryController@index');
Route::get('/all-category', 'CategoryController@all_category');
Route::post('/save-category', 'CategoryController@save_category');
Route::get('/unactive-category/{category_id}', 'CategoryController@unactive_category');
Route::get('/active-category/{category_id}', 'CategoryController@active_category');
Route::get('/edit-category/{category_id}', 'CategoryController@edit_category');
Route::get('/delete-category/{category_id}', 'CategoryController@delete_category');
Route::post('/update-category/{category_id}', 'CategoryController@update_category');
 

//related brand routers
Route::get('/add-brand', 'BrandController@index');
Route::get('/all-brand', 'BrandController@all_brand');
Route::post('/save-brand', 'BrandController@save_brand');
Route::get('/unactive-brand/{brand_id}', 'BrandController@unactive_brand');
Route::get('/active-brand/{brand_id}', 'brandController@active_brand');
Route::get('/edit-brand/{brand_id}', 'BrandController@edit_brand');
Route::get('/delete-brand/{brand_id}', 'BrandController@delete_brand');
Route::post('/update-brand/{brand_id}', 'BrandController@update_brand');


//related product routers
Route::get('/add-product', 'ProductController@index');
Route::get('/all-product', 'ProductController@all_product');
Route::post('/save-product', 'ProductController@save_product');
Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');
Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'ProductController@delete_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');



//related slider routers
Route::get('/add-slider', 'SliderController@index');
Route::get('/all-slider', 'SliderController@all_slider');
Route::post('/save-slider', 'SliderController@save_slider');
Route::get('/unactive-slider/{slider_id}', 'SliderController@unactive_slider');
Route::get('/active-slider/{slider_id}', 'SliderController@active_slider');
Route::get('/delete-slider/{slider_id}', 'SliderController@delete_slider');


//show product by category
Route::get('/product_by_category/{category_id}','HomeController@show_product_by_category');
Route::get('/product_by_brand/{category_id}','HomeController@show_product_by_brand');
Route::get('view-product/{product_id}','HomeController@show_product_by_id');


//cart routes 
Route::post('add_to_cart/','CartController@add_to_cart');
Route::get('show-cart/','CartController@show_cart');
Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');
Route::post('/update-cart','CartController@update_cart');

//checkout routes 
Route::get('/login-check','CheckoutController@login_check');
Route::post('/customer_registration','CheckoutController@customer_registration');
Route::get('/checkout','CheckoutController@checkout');
Route::post('/save-shipping-details','CheckoutController@save_shipping_details');


//customer login and logout 
Route::post('/customer_login','CheckoutController@customer_login');
Route::get('/customer_logout','CheckoutController@customer_logout');

//payment routers
Route::get('/payment','CheckoutController@payment');
Route::post('/order-place','CheckoutController@order_place');
Route::get('/manage-order','CheckoutController@manage_order');
Route::get('/view-order/{order_id}','CheckoutController@view_order');