<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Utils\PaginateCollection;


class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $areas = \DB::table('area as A')
            ->leftJoin('area as A2', 'A.parent', '=', 'A2.area_id')
            ->orderBy('A.description', 'ASC')
            ->select('A.area_id','A.description','A2.description as parent')
            ->get();
        $areas = PaginateCollection::paginate($areas, 5);
        
        return view ('area.list',compact("areas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        return view ('area.create', compact('areas'));
    }


    private function save (Request $request,$id=0){

        if  (intval($id)==0){
            $request->validate([
                'description' => ['required', 'string', 'unique:'.Area::class],
                'parent' => 'required',
            ],[
                'description.unique' => 'El área ya está registrada',
            ]);            
            $area = new Area();
        }
        else {
            $request->validate([
                'description' => ['required', 'string'],
                'parent' => 'required',
            ]);
             $area =  Area::find($id);
        }
        
        $area->description =  $request->description;
        $area->parent = $request->parent;
        $area->save();
       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->save($request);
        return redirect("areas")->with('success','Guardado correctamente');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::find($id); 
        $areas = Area::all();
        return view ("area.edit", compact("area","areas"));
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
          
        $this->save($request,$id);
        return redirect("areas")->with('success','Guardado correctamente');
        
    
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
