<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Hardware;
use App\Models\Computer;
use App\Models\Computersoftware;
use App\Models\Software;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Status;
use App\Models\Area;
use App\Models\Assignment;

use App\Utils\PaginateCollection;

class HardwareController extends Controller
{
    const MAX_IDS_THE_HARDWARE_WITH_SO=10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hardwares = \DB::table('hardware as H')
            ->leftJoin('category as C', 'H.category_id', '=', 'C.category_id')
            ->leftJoin('brand as D', 'H.brand_id', '=', 'D.brand_id')
            ->leftJoin('status as S', 'H.status_id', '=', 'S.status_id')
            ->leftJoin('assignment as B', 'H.hardware_id', '=', 'B.hardware_id')
            ->leftJoin('user as U', 'B.email', '=', 'U.email')
            ->leftJoin('area as A', 'A.area_id', '=', 'B.area_id')
            ->orderBy('H.inventorynumber', 'ASC')
            ->select('H.hardware_id','C.description as category','D.description as brand','S.description as status','U.name as user','A.description as area', 'H.inventorynumber', 'H.image', 'H.model', 'H.serial', 'H.comments', 'H.features')
            ->get();

            $hardwares = PaginateCollection::paginate($hardwares, 5);
            
            return view ('hardware.list',compact("hardwares"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all()->sortBy('description');
        $users = User::all()->sortBy('name');
        $brands = Brand::all()->sortBy('description');
        $categorys = Category::all()->sortBy('description');
        $statuses = Status::all();
        $softwares = Software::all()->sortBy('name');
        return view ('hardware.create',compact("categorys","brands","statuses","softwares", "areas", "users"));
    }


/************************************************************************* */
    public function validateData(Request $request){
        $inventorynumber = $request->inventorynumber;
        $validatedData = $request->validate([
            'inventorynumber' => ['bail','required', 'string'],
            'category_id' => ['bail','required','integer','min:1'], 
            'brand_id' => ['bail','required','integer'], 
            'status_id' => ['bail','required','integer'], 
            'serial' => ['bail','required','string'], 
            'model' => ['bail','required','string'], 
        ],[
            'inventorynumber.unique' => "El número de inventario $inventorynumber ya está registrada",
            'category_id.required' => "Es necesario indicar la categoria", 
            'brand_id.required' => "Es necesario indicar la marca", 
            'status_id.required' => "Es necesario indicar el estatus", 
            'serial.required' => "Es necesario indicar el numero de serie", 
            'model.required' => "Es necesario indicar el modelo", 
        ]);

        $category_id = $request->category_id;
        if ($category_id <= self::MAX_IDS_THE_HARDWARE_WITH_SO){
            $request->validate([
                'ram' => ['required', 'string'],
                'harddisk' => ['required','string'], 
                'processor' => ['required','string'], 
            ],[
                'ram.required' => 'Es necesario especificar la memoria RAM',
                'harddisk.required' => 'Es necesario indicar el almacenamiento',
                'processor.required'=>'Es necesario indicar las características del procesador'
            ]);

            $softwareIds = $request->software;
            if (count($softwareIds)<=0){
                return back()->with('error','Es necesario seleccionar al menos un elemento del software');

            }
        }

    }

    private function getImageName(Request $request, $image ){
        $imageName="";
        if ($request->hasFile($image)) {
            $imageName= $request->file($image)->getClientOriginalName();
            $request->file($image)->move(public_path('images/hardware'), $imageName);

        }
        return $imageName;
    }
/************************************************************************* */


     public function save(Request $request)
    {
        $this->validateData($request);
        $imageName = $this->getImageName($request,'image');
        $hardware_id = $request->hardware_id;
        $category_id = $request->category_id;
        try {
            DB::beginTransaction();
            if ($hardware_id>0){
                $hardware =  Hardware::find($hardware_id);
            }else {
                $hardware = new Hardware();
            }
            
            $hardware->inventorynumber = $request->inventorynumber;
            $hardware->category_id = $request->category_id;
            $hardware->brand_id = $request->brand_id;
            $hardware->status_id = $request->status_id;
            $hardware->features =  $request->features;
            $hardware->model =  $request->model;
            $hardware->comments =  $request->comments;
            $hardware->serial = $request->serial;
            $hardware->image = $imageName;
            $hardware->save();

            $computer = Computer::where('hardware_id','=',$hardware_id)->first();
            if ($computer){
                Computersoftware::where('computer_id','=', $computer->computer_id)->delete();
                Computer::where('hardware_id','=',$hardware_id)->delete();
            }

            
            if ($category_id <= self::MAX_IDS_THE_HARDWARE_WITH_SO){
                $computer = new Computer();
                $computer->hardware_id = $hardware->hardware_id;
                $computer->inventorynumber = $request->inventorynumber;
                $computer->identifier = $request->identifier;
                $computer->ram =  $request->ram;
                $computer->useros = $request->useros;
                $computer->harddisk = $request->harddisk;
                $computer->processor = $request->processor;
                $computer->save();

                
                $softwareIds = $request->software;
                foreach($softwareIds as $sofwareId) {
                    $computersoftware = new Computersoftware();
                    $computersoftware->computer_id = $computer->computer_id;
                    $computersoftware->software_id = $sofwareId;
                    $computersoftware->installationdate = date('Y-m-d'); 
                    $computersoftware->save();
                }

            }

            Assignment::where('hardware_id','=',$hardware_id)->delete();
            $assignment =  new Assignment();

            $assignment->hardware_id = $hardware->hardware_id;
            $assignment->area_id = $request->area_id; 
            $assignment->email = $request->email;
            $assignment->dateassignment = date('Y-m-d');
            $assignment->save();

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    } //--- end store


    public function store(Request $request) {
        if ($this->save($request)){
            return redirect('/hardwares');
        }else {
            return back()->with('error',"Ocurrió un error al guardar los datos");
        }
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
        $id = intval($id);
        $hardware = \DB::table('hardware as H')
        ->leftJoin('category as C', 'H.category_id', '=', 'C.category_id')
        ->leftJoin('brand as D', 'H.brand_id', '=', 'D.brand_id')
        ->leftJoin('status as S', 'H.status_id', '=', 'S.status_id')
        ->leftJoin('assignment as B', 'H.hardware_id', '=', 'B.hardware_id')
        ->leftJoin('user as U', 'B.email', '=', 'U.email')
        ->leftJoin('area as A', 'A.area_id', '=', 'B.area_id')
        ->leftJoin('computer as CO','H.hardware_id','=','CO.hardware_id')
        ->where ('H.hardware_id','=',$id)
        ->select('H.*','A.area_id','U.email','CO.computer_id', 'CO.identifier',
         'CO.ram', 'CO.useros', 'CO.harddisk', 'CO.processor')
        ->first();
        if (!$hardware){
            $data = ['success'=>false,
                'message'=>"Hardware inexistente",
                'urldestination'=>"history.back();"
                ];
            return view('message',compact('data'));
        }
        $softwares = Computersoftware::where('computer_id','=',$hardware->computer_id)
        ->select('software_id')
        ->get();
        $softwareSelected=[];
        foreach($softwares as $software){
            $softwareSelected[]=$software->software_id;
        }
        $areas = Area::all()->sortBy('description');
        $users = User::all()->sortBy('name');
        $brands = Brand::all()->sortBy('description');
        $categorys = Category::all()->sortBy('description');
        $statuses = Status::all();
        $softwares = Software::all()->sortBy('name');

        return view ('hardware.edit',
        compact('hardware','softwareSelected',
                'areas','categorys',
                'users','brands','softwares','statuses'));
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
        if ($this->save($request)){
            return redirect('/hardwares');
        }else {
            return back()->with('error',"Ocurrió un error al guardar los datos");
        }
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
