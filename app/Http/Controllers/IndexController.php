<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{



    public function productDetails($id){
        $product = Product::findOrFail($id);

     
        $multiImage = MultiImage::where('product_id',$id)->get();

     
        return view('product_details',compact('product','multiImage',));
    } // End Method





}





