<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Template;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::find(1);
        return view ('template.edit',compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $template =  Template::find(1);
        $logo = "logoitvo.jpg";
        if ($request->hasFile('logo')) {
            $logo= $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('images'), $logo);
        }
        $template->logo = $logo;
        $template->documentname = $request->documentname;
        $template->review =  $request->review;
        $template->code =  $request->code;
        $template->reference = $request->reference;
        $template->legendfootercenter = $request->legendfootercenter;
        $template->save();

        $data = [
            'message' =>  "Guardado satisfactoriamente ...",
            'success' => true,
            'urldestination'=>'window.history.back();'
        ];
        return view ('message', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
