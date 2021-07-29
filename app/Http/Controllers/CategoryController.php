<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    //
    public function Allcat(){

        //orm
        // $categories = Category::all();
        //$categories = Category::latest()->get();//ambil data order paling terakhir
        $categories = Category::latest()->paginate(5);//pagination
        $trashCat= Category::onlyTrashed()->latest()->paginate(3);
        ///querybuilder 
          //  $categories = DB::table('categories')->latest()->get();ambil data order paling terakhir
          //$categories = DB::table('categories')->latest()->paginate(5);

          //QUERY BUILDER JOIN 
         // $categories = DB::table('categories')->join('users', 'categories.user_id','users.id')->select("categories.*","users.name")->latest()->paginate(5);

        return view('admin.category.index',compact('categories','trashCat'));
    }


    public function Addcat(Request $request){


        $validated = $request->validate(
            [//untuk kondisi validasi
                'category_name' => 'required|unique:categories|max:255',
            ],
            [ // untuk messages error
                'category_name.required'=> 'Please input the Category Name',
                'category_name.unique'=>'Category must be unique',
                'category_name.max'=>'Character reach the limit 255 chars'
            ]
                );

    ////////ORM////////////////
    // Category::insert([
    //     "category_name"=>$request->category_name,
    //     "user_id"=>Auth::user()->id,
    //     "created_at"=>Carbon::now()
    // ]);
  
    // $category =new Category;
    // $category->category_name = $request->category_name;
    // $category->user_id = Auth::user()->id;
    // $category->created_at = Carbon::now();

    // $category->save();


     /////Query Builder/////////////


     $data =  array();
     $data['category_name'] = $request->category_name;
     $data['user_id'] = Auth::user()->id;
     $data['created_at']=Carbon::now();

     DB::table('categories')->insert($data);
     
    return Redirect()->back()->with("success","Category Inserted Successfull");
    // return view('admin.category.add');
     
    
    }


    public function Editcat($id){
        // $categories =Category::find($id);
        $categories = DB::table('categories')->where('id',$id)->first();
        return view('admin.category.edit',compact('categories'));
    }

    public function Updatecat(Request $request ,$id){

        $validated = $request->validate(
            [//untuk kondisi validasi
                'category_name' => 'required|unique:categories|max:255',
            ],
            [ // untuk messages error
                'category_name.required'=> 'Please input the Category Name',
                'category_name.unique'=>'Category must be unique',
                'category_name.max'=>'Character reach the limit 255 chars'
            ]
                );


        // $update = Category::find($id)->update([
        //     "category_name"=>$request->category_name,
        //     "user_id"=>Auth::user()->id,
        //     "updated_at"=>Carbon::now(),
        // ]);

        $data= array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        $data['updated_at']=Carbon::now();
        
        DB::table('categories')->where('id',$id)->update($data);

        return Redirect()->back()->with("success","Category Updated Successfull");
    }


    public function SoftDeletecat($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with("success","Category Delete Successfull");
    }

    public function Restorecat($id){
        $restore= Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with("success","Category Restored Successfull");
    }

    public function DeletePermanentcat($id){
        $delete= Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with("success","Category Deleted Permanent Successfull");

    }

}
