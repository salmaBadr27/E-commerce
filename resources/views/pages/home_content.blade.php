@extends('layout')
@section('content')
@include('slider');

<h2 class="title text-center">Features Items</h2>
        
			<?php
			 foreach ($all_product as $product){?>
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{URL::to($product->product_image)}}" alt="" />
											<h2>{{$product->product_price}}</h2>
											<p>{{$product->product_name}}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
								<div class="product-overlay">
										<div class="overlay-content">
											<h2>{{$product->product_price}}</h2>
											<a href="{{URL::to('view-product/'.$product->product_id)}}"><p>{{$product->product_name}}</p></a>
											<a href="{{URL::to('view-product/'.$product->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
										</div>
								</div>		
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
										<li><a href="{{URL::to('view-product/'.$product->product_id)}}"><i class="fa fa-plus-square"></i>view Product</a></li>
									</ul>
								</div>
							</div>
						</div>
						<!-- </div> -->
			<?php }?>
							
				</div>			
					

						
						
@endsection