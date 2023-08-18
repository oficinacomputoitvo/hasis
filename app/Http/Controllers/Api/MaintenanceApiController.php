<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\GenericController;
use App\Http\Requests\MaintenanceRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Maintenanceschedule;
use App\Models\Maintenancescheduleservice;
use App\Models\Maintenancescheduleservicedetail;

class MaintenanceApiController extends  GenericController
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

   
    
    private function prepareData(Request $request){
        $data= [
            "schoolcycle"=>$request->schoolcycle,
            "year"=>$request->year,
            "whoelaborated"=>$request->whoelaborated,
            "dateofpreparation"=>$request->dateofpreparation,
            "dateofapproval"=>$request->dateofapproval,
            "whoautorized"=>$request->whoautorized
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //--- check if there is
        $maintenanceSchedule = Maintenanceschedule::where('schoolcycle','=',$request->schoolcycle)->first();
        if (!$maintenanceSchedule){
            $fields = $this->prepareData($request);
            $maintenanceSchedule= Maintenanceschedule::create($fields);
        }

        $json = json_decode($maintenanceSchedule->toJson());
        $json->maintenancescheduleservice=[];
        //--- retrive data 
        $maintenanceScheduleServices = Maintenancescheduleservice::where 
            ('maintenanceschedule_id','=', $maintenanceSchedule->maintenanceschedule_id)
            ->get();

        foreach ($maintenanceScheduleServices as $maintenanceScheduleService){
            $mssJson = json_decode($maintenanceScheduleService->toJson());

            $maintenanceScheduleServiceDetails = Maintenancescheduleservicedetail::where
                ('maintenancescheduleservice_id','=',$maintenanceScheduleService->maintenancescheduleservice_id)->get();
           
            foreach ($maintenanceScheduleServiceDetails as $maintenenceScheduleServiceDetail){
                $mssJson->maintenancescheduleservicedetail[] = json_decode($maintenenceScheduleServiceDetail->toJson());
            }
            $json->maintenancescheduleservice[]=$mssJson;
        }
       
        $resp = $this->sendResponse("Proceso exitoso", [$json]);
        return($resp);
 
    }

    public function addService(Request $request){
        $data = [
            'number' => $request->number,
            'maintenanceschedule_id' => $request->maintenanceschedule_id,
            'service' => $request->service,
            'type' => $request->type,
        ];

        try {
            DB::beginTransaction();
            if ($request->maintenancescheduleservice_id==0)
                $maintenancescheduleservice = Maintenancescheduleservice::create($data);
            else {
                $maintenancescheduleservice = Maintenancescheduleservice::find($request->maintenancescheduleservice_id);
                $maintenancescheduleservice->update($data);
                Maintenancescheduleservicedetail::where('maintenancescheduleservice_id','=',$request->maintenancescheduleservice_id)->delete();
            }

            $details =  $request->details;

            foreach($details as $detail ){
                $serviceDetail = new Maintenancescheduleservicedetail();
                $serviceDetail->maintenancescheduleservice_id = $maintenancescheduleservice->maintenancescheduleservice_id;
                $serviceDetail->time = $detail["time"] ?? "";
                $serviceDetail->january = $detail["january"] ?? "";
                $serviceDetail->february = $detail["february"] ?? "";
                $serviceDetail->march = $detail["march"] ?? "";
                $serviceDetail->april = $detail["april"] ?? "";
                $serviceDetail->may = $detail["may"] ?? "";
                $serviceDetail->june = $detail["june"] ?? "";
                $serviceDetail->july = $detail["july"] ?? "";
                $serviceDetail->august = $detail["august"] ?? "";
                $serviceDetail->september = $detail["september"] ?? "";
                $serviceDetail->october = $detail["october"] ?? "";
                $serviceDetail->november = $detail["november"] ?? "";
                $serviceDetail->december = $detail["december"] ?? "";
                $serviceDetail->save();

            }
            DB::commit();
            $resp = $this->sendResponse("Guardado satisfactoriamente", $maintenancescheduleservice);

        } catch (\Exception $e) {
            DB::rollback();
            $resp = $this->sendError("Error al guardar los datos", $e->getMessage());
        }
        return($resp);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
