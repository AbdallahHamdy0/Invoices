<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=sections::all();
        return view('sections.sections',compact('sections'));
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
        $inputs= $request->all();
        
        $validate_data=$request->validate([
            'section_name'=>'required|unique:sections',
            'description'=>'required',
        ],[
            'section_name.required'=>'برجاء إدخال اسم القسم  ',
            'section_name.unique'=>' اسم القسم موجود مسبقاً ',
            'description.required'=>'برجاء إدخال الوصف   ',

        ]);
            sections::create([
                'section_name'=>$inputs['section_name'],
                'description'=>$inputs['description'],
                'created_by'=>Auth::user()->name,
            ]);
            session()->flash('Add','تم إضافة القسم بنجاح ');
            return redirect('/sections');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sections $sections)
    {   
        $id=$request->id;
        $validate_data=$request->validate([
            'section_name'=>'required|unique:sections,section_name,'.$id,
            'description'=>'required',
        ],[
            'section_name.required'=>'برجاء إدخال اسم القسم  ',
            'section_name.unique'=>' اسم القسم موجود مسبقاً ',
            'description.required'=>'برجاء إدخال الوصف   ',

        ]);
        $section=sections::find($id);
        $section->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description
        ]);
        session()->flash('Edit','تم التعديل  بنجاح ');
            return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section=sections::find($id);
        $section->delete();
        session()->flash('Error','تم الحذف');
            return redirect('/sections');
    }
}

