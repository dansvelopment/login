<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Image;

class BrandController extends Controller
{
    
    //
    public function Allbrand(){
        $brands= Brand::latest()->paginate(3);
        return view('admin.brand.index',compact('brands'));
    }

    public function Addbrand(Request $request){
        $validate= $request->validate([
            'brand_name'=>'required|unique:brands|min:4',
            'brand_image'=>'required|mimes:jpg,jpeg,png'
        ],
        [
           'brand_name.required'=>"Maaf masukan nama brand",
           'brand_name.unique'=>"nama brand telah terdaftar",
           'brand_name.max'=>'Minimum karakter 4 ',
           'brand_image.required'=>"maaf file harus dimasukan"
            
        ]);
    

         $brand_image= $request ->file('brand_image'); //ngambil file 
        // $image_ext =strtolower($brand_image->getClientOriginalExtension());// ngambil extension file
        // $name_rand =hexdec(uniqid()); //generate random id
        // $img_name= $name_rand.'.'.$image_ext; //bikin nama file
        // $folder_location = 'image/brand/'; 
        // $saved_image=$folder_location.$img_name;//ngambil path file nya
        // $brand_image->move($folder_location,$img_name);

        $img_file = 'image/brand/'.hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(400,500)->save($img_file);


        Brand::insert([
            'brand_name'=> $request->brand_name,
            'brand_image'=> $img_file,
            'created_at'=> Carbon::now()

        ]);

        return Redirect()->back()->with('success','Brand Inserted successfully');
    }

    public function Editbrand($id){
        $brands = Brand::find($id);
        return view('admin.brand.edit',compact('brands'));
    }

    public function Updatebrand(Request $request, $id){
        $validate= $request->validate([
            'brand_name'=>'required|unique:brands|min:4',
           
        ],
        [
           'brand_name.required'=>"Maaf masukan nama brand",
           'brand_name.unique'=>"nama brand telah terdaftar",
           'brand_name.max'=>'Minimum karakter 4 ',
            
        ]);
        $old_image =$request->old_image;

        $brand_image= $request ->file('brand_image'); //ngambil file 


        if($brand_image){
            $image_ext =strtolower($brand_image->getClientOriginalExtension());// ngambil extension file
            $name_rand =hexdec(uniqid()); //generate random id
            $img_name= $name_rand.'.'.$image_ext; //bikin nama file
            $folder_location = 'image/brand/'; 
            $saved_image=$folder_location.$img_name;//ngambil path file nya
            $brand_image->move($folder_location,$img_name);
    
            unlink($old_image);
            Brand::find($id)->update([
                "brand_name"=> $request->brand_name,
                "brand_image"=> $saved_image,
                "updated_at"=> Carbon::now()
    
    
    
            ]);
    
        }else{
            Brand::find($id)->update([
                "brand_name"=> $request->brand_name,
                "updated_at"=> Carbon::now()
    
    
    
            ]);
        }
       
        return Redirect()->back()->with('success',"Brand Updated Successfully");
    }


    public function Deletebrand($id)
    {

        $image = Brand::find($id);
        unlink($image->brand_image);
         Brand::find($id)->delete();
         return Redirect()->back()->with('success',"Brand deleted Successfully");
    }
}
