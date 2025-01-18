<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        return view('sections.sections', compact('sections'));

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


        $this->validate(
            $request,
            [
                'section_name' => 'required|unique:sections|max:255',
            ],
            [
                'section_name.required' => 'برجاء ادخال اسم القسم',
                'section_name.unique' => 'هذا القسم مسجل مسبقا',
            ]
        );
        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);
        session()->flash('Add', 'تم الاضافة بنجاح');
        return redirect('/sections');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $section_id = $request->id;
        $this->validate(
            $request,
            [
                'section_name' => 'required|unique:sections,id|max:255',
                'description' => 'required',
            ],
            [
                'section_name.required' => 'يرجي ادخال اسم القسم',
                'section_name.unique' => 'هذا القسم مسجل مسبقا',
                'description.required' => 'يرجي ادخال الملاحظات',
            ],
        );
        $sections = sections::find($section_id);
        $sections->update(
            [
                'section_name' => $request->section_name,
                'description' => $request->description,
            ]
        );
        session()->flash('edit', 'تم تعديل القسم بنجاح');

        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $section_id = $request->id;
        sections::find($section_id)->delete();
        session()->flash('delete', 'تم الحذف بنجاح');
        return redirect('/sections');
    }
}
