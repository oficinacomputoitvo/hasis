<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicetype;
use App\Models\Servicerequest;
use App\Models\Executionofservice;
use App\Enums\ServiceStatusEnum;
use App\Enums\RolEnum;
use App\Utils\PaginateCollection;


class ExecutionOfServiceController extends Controller
{

     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $initialdate =  $request->get('initialdate')?? (date('Y')."-01-01");
        $finaldate =  $request->get('finaldate')??date('Y-m-d');

        $executionOfServices = \DB::table('executionofservice as ES')
        ->leftjoin('user as A','ES.email','=','A.email')
        ->leftjoin('servicerequest as SR','ES.servicerequest_id','=','SR.servicerequest_id')
        ->leftjoin('user as U','SR.email','=','U.email')        
        ->where('SR.status','>=', ServiceStatusEnum::ATTENDED->value)
        ->where('ES.dateofservice','>=',$initialdate)
        ->where('ES.dateofservice','<=',$finaldate)
        ->select('ES.executionofservice_id','ES.servicerequest_id',
            'SR.folio','SR.daterequest',
            'ES.dateofservice','U.name as requester','ES.actions','ES.materialsused',
            'ES.datereleased','ES.dateapproved','A.name as approved','SR.status')
        ->get();

        if (count($executionOfServices)<=0){
            $data = [
                'message' =>  "No hay orden de trabajo a presentar",
                'success' => false,
                'urldestination'=>'window.location.href="/dashboards"'
            ];
            return view ('message', compact('data'));
        }
        $executionOfServices = PaginateCollection::paginate($executionOfServices, 5);
        return view ("executionofservice.list", compact('executionOfServices'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $services = \DB::table('servicerequest as SR')
        ->leftjoin('user as U', 'SR.email','=','U.email')
        ->where('SR.status','=', ServiceStatusEnum::RECEIVED->value)
        ->select('SR.servicerequest_id','SR.folio','SR.daterequest',
            'SR.description','U.name as requester')
        ->get();

        

        $servicesType =  Servicetype::all();

        if (count($services)<=0){
            $data = [
                'message' =>  "No hay mas solicitudes pendientes ",
                'success' => false,
                'urldestination'=>'window.location.href="/dashboards"'
            ];
            return view ('message', compact('data'));
        }
        $users = \DB::table('user as U')
        ->leftjoin('roluser as RU','U.email','=','RU.email')
        ->where('RU.rol_id','<', RolEnum::REQUESTER->value)
        ->get();
        $services = PaginateCollection::paginate($services, 1);
        return view ("executionofservice.create", compact('services','servicesType','users'));

    }

    public function validateData(Request $request){

        $request->validate([
            'servicerequest_id' => 'required',
            'internalservice' => 'required',
            'servicetype_id'=>'required',
            'assigned' => 'required',
            'dateofservice'=>'required|date',
            'actions' => 'required',
            'materialsused' =>'required'
        ],[
            'servicerequest_id.required' => 'Es necesario seleccionar el servicio',
            'internalservice.required' => 'Es necesario indicar el tipo de manternimiento',
            'servicetype_id.required' => 'Es necesario indicar el tipo de servicio',
            'assigned.required' => 'Es necesario indicar a quien está asignado el trabajo',
            'dateofservice.required' => 'Es necesario indicar la fecha en que se hizo el servicio',
            'actions.required' => 'Es necesario indicar la actividad que se realizó',
            'materialsused.required' => 'Es necesario proporcionar la información de los materiales utilizados'
        ]
        );

    }

    private function save (Request $request,$id=0){
        $this->validateData($request);
        try {
            if  (intval($id)==0){
                $executionOfService = new Executionofservice();
            }
            else {
                $executionOfService =  Executionofservice::find($id);
            }

            $serviceRequest = Servicerequest::find($request->servicerequest_id);
            
            $executionOfService->servicetype_id =  $request->servicetype_id;
            $executionOfService->servicerequest_id = $request->servicerequest_id;
            $executionOfService->email = $request->assigned;
            $executionOfService->dateofservice = $request->dateofservice;
            $executionOfService->actions = $request->actions;
            $executionOfService->materialsused = $request->materialsused;
            $executionOfService->internalservice = $request->internalservice;
            $executionOfService->hardware_id = $serviceRequest->hardware_id;            
            $executionOfService->save();
            //--- notificar al usuario

            return true;
        } catch(Exception  $ex){
            return false;
        }
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
  
        $this->validateData($request);
        
        if ($this->save($request, $request->executionofservice_id)) {
            $data = [
                'message' =>  "Guardado satisfactoriamente ...",
                'success' => true,
                'urldestination'=>'window.location.href ="executionofservices/create"'
            ];
        }else {
            $data = [
                'message' =>  "Hubo un error al guardar",
                'success' => false,
                'urldestination'=>'window.history.back();'
            ];
        }
        return view ('message', compact('data'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
