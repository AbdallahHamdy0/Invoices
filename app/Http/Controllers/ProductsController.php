<?php

namespace App\Http\Controllers;

use App\products;
use App\sections;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=sections::all();
        $products=products::all();
        return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validate_data=$request->validate([
            'product_name'=>'required|unique:products',
            'description'=>'required',
            'section_id'=>'required'
        ],[
            'product_name.required'=>'برجاء إدخال اسم المنتج  ',
            'product_name.unique'=>' اسم المنتج موجود مسبقاً ',
            'description.required'=>'برجاء إدخال الوصف   ',
            'section_id.required'=>'برجاء اختيار القسم '
        ]);
        products::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id,
        ]);
        session()->flash('Add','تم إضافة المنتج بنجاح ');

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $validate_data=$request->validate([
            'product_name'=>'required|unique:products,product_name,'.$id,
            'description'=>'required',
            'section_name'=>'required'
        ],[
            'product_name.required'=>'برجاء إدخال اسم المنتج  ',
            'product_name.unique'=>' اسم المنتج موجود مسبقاً ',
            'description.required'=>'برجاء إدخال الوصف   ',
            'section_name.required'=>'برجاء اختيار القسم '
        ]);
       $section_id=sections::where('section_name',$request->section_name)->first()->id;
        $product=products::findOrFail($id);
        $product->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$section_id
        ]);
        session()->flash('Edit','تم تعديل المنتج بنجاح ');

        return redirect('/products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=products::find($id);
        $product->delete();
        session()->flash('Error','تم الحذف');
            return redirect('/products');
    }
}
