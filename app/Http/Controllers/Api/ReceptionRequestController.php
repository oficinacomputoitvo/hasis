<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\GenericController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ServicerequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use App\Models\Receptionofrequest;
use App\Models\User;
use App\Models\Servicerequest;
use App\Models\Servicerequesthardware;



class ReceptionRequestController extends GenericController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    public function save(Request $request){
        
        $today = date('Y-m-d');
        
        $data = ["servicerequest_id" => $request->servicerequest_id,
                "datereception" => $today,
                "email" => $request->email,
                "probabledateexecution"=>$request->probabledateexecution,
                "comment" => $request->comment
        ];
        $probabledateexecution = $request->probabledateexecution;
        [$anio,$mes,$dia] = explode("-",$probabledateexecution);
        $probabledateexecution = "$dia-$mes-$anio";
        
        $receptionofrequest = Receptionofrequest::create($data);

        $user = User::where('email','=',$request->email)->first();

        $servicerequest = \DB::table('servicerequest as SR')
        ->leftjoin('user as U','SR.email','=','U.email')
        ->where('SR.servicerequest_id','=', $request->servicerequest_id)
        ->select('SR.servicerequest_id','SR.daterequest','SR.folio','U.name as requester',
            'SR.email','SR.daterequest','SR.description')
        ->first();

        $hardware = Servicerequesthardware::where('servicerequest_id','=',$request->servicerequest_id)->first();

        $areaDescription = (new ServicerequestController())->getArea($hardware->hardware_id);

        $content = ["receptiondate" => date('d-m-Y'),
            "folio" => $servicerequest->folio,
            "description" => $servicerequest->description,
            "requester" => $servicerequest->requester,
            "area" => $areaDescription,
            "probabledateexecution" => $probabledateexecution,
            "comment" => $request->comment,
            "username" => $user->name??""
        ];
        
        $mailController = new MailController();
        $mailController->send( "reception",
            "Recepción de Solicitud de Mantenimiento Correctivo",
            $content, $servicerequest->email);

        $resp = $this->sendResponse("Guardado satisfactoriamente", $receptionofrequest);
        return($resp);
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
