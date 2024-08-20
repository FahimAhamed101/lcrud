<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ProductControllerApi extends Controller
{
    
    public function indexapi()
    {
        $customers = Product::all();
        return response()->json([
            'status' => true,
            'message' => 'Customers retrieved successfully',
            'data' => $customers
        ], 200);
    }
    public function show($id)
    {
        $customer = Product::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Customer found successfully',
            'data' => $customer
        ], 200);
    }
    public function add(){
       
       
        return view('add');
    } // End Method
    public function storeapi(Request $request)
    {
        $image = $request->file('product_thumbnail');
        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img=$manager->read($image);
        $img= $img->resize(1100,1100);
        
        $uploadPath = 'media/multiImage/'.$name_gen;
        $img-> toJpeg(88)->save($uploadPath);
        $product_id = Product::insertGetId([
         
            'product_name' => $request->product_name,
            'product_thumbnail' => $uploadPath,
            'long_disc' => $request->long_disc,
            
            'created_at' => Carbon::now(),
        ]);
        // Multiple Image Uploaded -----------------------------------------------------
        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $manager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();

            $img=$manager->read($img);
            $img= $img->resize(1100,1100);
            
            $uploadPath = 'media/multiImage/'.$make_name;
            $img-> toJpeg(88)->save($uploadPath);
            MultiImage::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        }
        
        
        
        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $product_id
        ], 201);
    }
    public function Store(Request $request){
      
        $product_id = Product::insertGetId([
         
            'product_name' => $request->product_name,
        'product_thumbnail' => $uploadPath,
            'long_disc' => $request->long_disc,
            
            'created_at' => Carbon::now(),
        ]);
        // Multiple Image Uploaded -----------------------------------------------------
        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $manager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();

            $img=$manager->read($img);
            $img= $img->resize(1100,1100);
            
            $uploadPath = 'media/multiImage/'.$make_name;
            $img-> toJpeg(88)->save($uploadPath);
            MultiImage::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        } // Multi Image Method End
        $notification=array(
            'message'=>'Product All Information Add Successfully ',
            'alert'=>'success'
        );
        return Redirect()->route('product')->with($notification);


    } // End Method

    public function Edit($id){
        $multi_image = MultiImage::where('product_id',$id)->get();
    
        $product = Product::findOrFail($id);
        return view('edit',compact('product','multi_image'));

    } // End Method

    public function Update(Request $request){
        $product_id = $request->id;

            Product::findOrFail($product_id)->Update([
          
            'product_name' => $request->product_name,
       
        
            'long_disc' => $request->long_disc,
          
           
            'updated_at' => Carbon::now(),
        ]);
        $notification=array(
            'message'=>'Product Update Without Image Successfully ',
            'alert'=>'success'
        );
        return Redirect()->route('product')->with($notification);

    } // End Method

    // Main Image Update Code ---------------------------------------

    public function MainImageUpdate(Request $request){
        $pro_id = $request->id;
        $oldImage = $request->old_img;
        $image = $request->file('product_thumbnail');
       $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img=$manager->read($image);
        $img= $img->resize(1100,1100);
        
        $uploadPath = 'media/multiImage/'.$name_gen;
        $img-> toJpeg(88)->save($uploadPath);

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }
      
        Product::findOrFail($pro_id)->update([
            'product_thumbnail' => $uploadPath,
            'updated_at' => Carbon::now(),
        ]);
        $notification=array(
            'message'=>'Product Image Update Successfully ',
            'alert'=>'success'
        );
        return Redirect()->back()->with($notification);
    }// End Method


    // MultiImage Update ----------------------------------------------

    public function MultiImageUpdate (Request $request){
        $imgs = $request ->multi_images;
        foreach ($imgs as $id => $img) {
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $manager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();

            $img=$manager->read($img);
            $img= $img->resize(1100,1100);
            
            $uploadPath = 'media/multiImage/'.$make_name;
            $img-> toJpeg(88)->save($uploadPath);
            MultiImage::where('id',$id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
         
            $notification=array(
                'message'=>'Product Multiple Image Update Successfully ',
                'alert'=>'success'
            );
            return Redirect()->back()->with($notification);
        }
    } /// end method


    // MultiImage Delete ---------------------------------------------------------------------

    public function MultiImageDelete ($id){
        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);
        MultiImage::findOrFail($id)->delete();
        $notification=array(
            'message'=>'Product Multiple Image Delete Successfully ',
            'alert'=>'success'
        );
        return Redirect()->back()->with($notification);
    } // end method




    public function Delete($id){
        $product = Product::findOrFail($id);
        unlink($product->product_thumbnail);
        Product::findOrFail($id)->delete();

        $images = MultiImage::where('product_id',$id)->get();
        foreach ($images as  $img) {
            unlink($img->photo_name);
            MultiImage::where('product_id',$id)->delete();
        }
        $notification=array(
            'message'=>'Product Delete Successfully ',
            'alert'=>'success'
        );
        return Redirect()->back()->with($notification);
    } 


}