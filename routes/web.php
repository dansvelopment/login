<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about',function(){
   return view('about');
})->name('test');
Route::get('/contact',[ContactController::class,'index'])   ;

/////////////CATEGORY///////////////////////////////
Route::get('/category/all',[CategoryController::class,'Allcat'])->name('all.category');

Route::post('/category/add',[CategoryController::class,'Addcat'])->name('store.category');

Route::get('/category/edit/{id}',[CategoryController::class,'Editcat']);
Route::post('/category/update/{id}',[CategoryController::class,'Updatecat']);
Route::get('/category/softdelete/{id}',[CategoryController::class,'SoftDeletecat']);
Route::get('/category/restore/{id}',[CategoryController::class,'Restorecat']);
Route::get('/category/deletepermanent/{id}',[CategoryController::class,'DeletePermanentcat']);

///////BRAND///////////////////////////////////////////////

Route::get('/brand/all',[BrandController::class,'Allbrand'])->name('all.brand');
Route::post('/brand/add',[BrandController::class,'Addbrand'])->name('store.brand');
Route::get('/brand/edit/{id}',[BrandController::class,'Editbrand']);
Route::post('/brand/update/{id}',[BrandController::class,'Updatebrand']);
Route::get('/brand/delete/{id}',[BrandController::class,'Deletebrand']);



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //$users= User::all(); //ORM OBJECT RELATION MODEL
    $users = DB::table('users')->get();
    return view('dashboard',compact('users'));
})->name('dashboard');
