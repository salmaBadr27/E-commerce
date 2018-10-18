@extends('admin_layout')
@section('admin_content')
	
			
<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="index.html">Home</a>
        <i class="icon-angle-right"></i> 
    </li>
    <li>
        <i class="icon-edit"></i>
        <a href="#">Add Product</a>
    </li>
</ul>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Add Product</h2>
           
        </div>
        <p class="alert-success">
                <?php
                $message=Session::get('message');
                if($message){
                    echo $message;
                    Session::put('message',null);
                }
                ?>
        <div class="box-content">
           
        <form class="form-horizontal"  action ="{{URL::to('/save-product')}}" method = "post" enctype="multipart/form-data">
                {{csrf_field()}}
              <fieldset>
                <div class="control-group">
                  <label class="control-label" for="date01">product name</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="product_name" required>
                  </div>
                  
                  <div class="control-group">
								<label class="control-label" for="selectError3">Product category</label>
								<div class="controls">
                 <select name="category_id">
                 <option>select category</option>
                       <?php 
                    $all_category = DB::table('categories')
								 ->where('publication_status',1)
								 ->get();
                  foreach ($all_category as $category){?>
                  <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                  <?php }?>
								  </select>
								</div>
                              </div>
                              <div class="control-group">
								<label class="control-label" for="selectError3">Brand</label>
								<div class="controls">
								  <select name="brand_id">
                  <option>select brand</option>
                  <?php 
								 $all_brand = DB::table('brands')
								 ->where('publication_status',1)
								 ->get();
							foreach ($all_brand as $brand){?>
									<option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                  <?php }?>
								  </select>
								</div>
							  </div>
                  <div class="control-group">
                  <label class="control-label" for="date01">product size</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="product_size" required>
                  </div>
                  <div class="control-group">
                  <label class="control-label" for="date01">product color</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="product_color" required>
                  </div>
                </div>
                <div class="control-group hidden-phone">
                  <label class="control-label" for="textarea2">product_short_description</label>
                  <div class="controls">
                    <textarea class="cleditor" name="product_short_description" rows="3" required></textarea>
                  </div>
                  <div class="control-group hidden-phone">
                  <label class="control-label" for="textarea2">product_long_description</label>
                  <div class="controls">
                    <textarea class="cleditor" name="product_long_description" rows="3" required></textarea>
                  </div>
                  <div class="control-group">
							  <label class="control-label" for="fileInput">image</label>
							  <div class="controls">
								<input class="input-file uniform_on" name="product_image" id ="fileInput" type="file">
							  </div>
							</div>   
              <div class="control-group">
                  <label class="control-label" for="date01">product sprice</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="product_price" required>
                  </div>
                  <div class="control-group hidden-phone">
                    <label class="control-label" for="textarea2">Publication status</label>
                    <div class="controls">
                        <input type= "checkbox" name = "publication_status" value = "1">
                    </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Add product</button>
                  <button type="reset" class="btn">Cancel</button>
                </div>
              </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->
@endsection