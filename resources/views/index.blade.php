@extends('admin_dashboard')


@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
          
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('product.add') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
        </div>
    
        <div class="container">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>view detail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>
                                    <img src="{{ asset( $item->product_thumbnail ) }}" style="width: 70px; height:40x;" alt="">
                                </td>
                                <td>
                                    <a href="{{ url('product/details/'.$item->id) }}">{{ $item->product_name }}</a></h2>
                                </td>
                             
                        

                                <td>
                                    <a href="{{ route('product.edit',$item->id) }}" class="btn btn-info">Edit</a>
                              
                                     <a href="{{ route('product.delete',$item->id) }}" id="delete" class="btn btn-danger">Delete</a>


                               
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                     
                    </table>
                </div>
            </div>
        </div>
    
    </div>
    @endsection