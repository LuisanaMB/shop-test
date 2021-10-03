<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Schema::hasTable('users')){
            $products = Product::orderBy('name', 'ASC')->get();

            return view('step1')->with(compact('products'));
        }else{
            return redirect('install');
        } 
    }
}
