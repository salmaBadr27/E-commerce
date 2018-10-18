@extends('admin_layout')
@section('admin_content')
			
<ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Tables</a></li>
    </ul>

    <div class="row-fluid sortable">		
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>Brands</h2>
            </div>
            <div class="box-content">
                    <p class="alert-success">
                            <?php
                            $message=Session::get('message');
                            if($message){
                                echo $message;
                                Session::put('message',null);
                            }
                            ?>
                            </p>
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th>Brand id</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th> status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>   
                  @foreach($all_brand as $brand) <!-- loop through allcategories d=fetched from database and put them in table-->
                  <tbody>
                    <tr>
                        <td>{{$brand->brand_id}}</td>
                        <td class="center">{{$brand->brand_name}}</td>
                        <td class="center">{{$brand->brand_description}}</td>
                        <td class="center">
                            @if($brand->publication_status == 1)
                            <span class="label label-success">Active</span>
                            @else
                            <span class="label label-danger">nonActive</span>
                            @endif
                        </td>
                        <td class="center">
                                @if($brand->publication_status == 1)
                             <a class="btn btn-success" href="{{URL::to('/unactive-brand/'.$brand->brand_id)}}">
                                <i class="halflings-icon white thumbs-up"></i> 
                            </a>
                                @else 
                        <a class="btn btn-danger" href="{{URL::to('/active-brand/'.$brand->brand_id)}}">
                                <i class="halflings-icon white thumbs-down"></i>
                            </a> 
                                @endif
                               
                           
                            <a class="btn btn-info" href="{{URL::to('/edit-brand/'.$brand->brand_id)}}">
                                <i class="halflings-icon white edit"></i>  
                            </a>
                            <a class="btn btn-danger" href="{{URL::to('/delete-brand/'.$brand->brand_id)}}">
                                <i class="halflings-icon white trash"></i> 
                            </a>
                        </td>
                    </tr>
                   
                  </tbody>
                  @endforeach
              </table>            
            </div>
        </div><!--/span-->


   
  
  
@endsection