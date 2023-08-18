<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicetype;
use App\Models\Servicerequest;
use App\Models\Executionofservice;
use App\Models\Template;
use App\Models\Servicerequesthardware;
use App\Enums\ServiceStatusEnum;
use App\Enums\RolEnum;
use App\Utils\PaginateCollection;
use PDF;

class WorkOrderController extends Controller
{
    public function preview(Request $request){

        $executionofservice_id= intval($request->executionofservice_id ?? "0");

        $initialdate =  $request->initialdate ?? (date('Y')."-01-01");
        $finaldate =  $request->finaldate ?? date('Y-m-d');

        $executionofservice = \DB::table('executionofservice as ES')
        ->leftjoin('user as A','ES.email','=','A.email')
        ->leftjoin('servicerequest as SR','ES.servicerequest_id','=','SR.servicerequest_id')
        ->leftjoin('user as U','SR.email','=','U.email')  
        ->leftjoin('user as AP','ES.approved','=','AP.email')   
        ->leftjoin('servicetype as ST','ES.servicetype_id','=','ST.servicetype_id')
        ->where('ES.executionofservice_id','=',$executionofservice_id)
        ->where('SR.status','>=', ServiceStatusEnum::ATTENDED->value)
        ->where('ES.dateofservice','>=',$initialdate)
        ->where('ES.dateofservice','<=',$finaldate)
        ->select('ES.executionofservice_id','ES.servicerequest_id','SR.folio','SR.daterequest',
            'ES.dateofservice','U.name as requester','ES.actions','ES.materialsused',
            'ES.datereleased','ES.dateapproved','A.name as whoperformedtheservice','SR.status',
            'ES.internalservice','ST.description as servicetype','AP.name as approver')
        ->first();


        if (!$executionofservice){
            $data=[
                "success"=>false,
                "message"=>"No existe un orden de trabajo con el identificador indicado",
                "urldestination"=>"window.history.back();"
            ];
            return view ("message",compact('data'));
        }

        $hardwares = \DB::table('servicerequesthardware as SRH')
            ->leftjoin('hardware as H','H.hardware_id','=','SRH.hardware_id')
            ->where('servicerequest_id','=',$executionofservice->servicerequest_id)
            ->get();
        

        $data = [
            'date' => date('m/d/Y'),
            'executionofservice' => $executionofservice,
            'template' => Template::find(1),
            'hardwares' => $hardwares
        
        ]; 
        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf = PDF::loadView('workorder.preview', $data );
        $pdf->set_paper('letter', 'portrait');

        return $pdf->stream('orden_trabajo_mantenimiento.pdf');        
    }

    public function listxrelease(Request $request){
        $initialdate =  $request->initialdate ?? (date('Y')."-01-01");
        $finaldate =  $request->finaldate ?? date('Y-m-d');

        $rol = $request->session()->get('rol')??"0";
        $email= $request->session()->get('email')??"";

        if ($rol != RolEnum::REQUESTER->value){
            $data = [
                'message' =>  "Operación no permitida",
                'success' => false,
                'urldestination'=>'window.history.back();'
            ];
            return view ('message', compact('data'));
        }

        $executionofservices = \DB::table('executionofservice as ES')
        ->leftjoin('hardware as H','ES.hardware_id','=','H.hardware_id')
        ->leftjoin('user as A','ES.email','=','A.email')
        ->leftjoin('servicerequest as SR','ES.servicerequest_id','=','SR.servicerequest_id')
        ->leftjoin('user as U','SR.email','=','U.email')  
        ->leftjoin('user as AP','ES.approved','=','AP.email')   
        ->leftjoin('servicetype as ST','ES.servicetype_id','=','ST.servicetype_id')
        ->where('SR.status','=', ServiceStatusEnum::ATTENDED->value)
        ->where('ES.dateofservice','>=',$initialdate)
        ->where('ES.dateofservice','<=',$finaldate)
        ->where('U.email','=',$email)
        ->select('ES.executionofservice_id','ES.servicerequest_id','SR.folio','SR.daterequest',
            'ES.dateofservice','U.name as requester','ES.actions','ES.materialsused',
            'ES.datereleased','ES.dateapproved','A.name as whoperformedtheservice',
            'SR.status','H.features as hardware',
            'ES.internalservice','ST.description as servicetype','AP.name as approved')
        ->get();


        if (count($executionofservices)<=0){
            $data = [
                'message' =>  "No hay órdenes de trabajo de mantenimiento pendientes por liberar",
                'success' => false,
                'urldestination'=>'window.location.href="/dashboards"'
            ];
            return view ('message', compact('data'));
        }
        $executionofservices = PaginateCollection::paginate($executionofservices, 10);
        return view('workorder.listxrelease',compact('executionofservices','rol'));

    }

    public function release(Request $request){
        $rol = $request->rol_id;
        $executionofservice_id = $request->executionofservice_id;
        $servicerequest_id = $request->servicerequest_id;
        $rating = $request->rating;
        $executionofservice = Executionofservice::find($executionofservice_id);
        $servicerequest = Servicerequest::find($servicerequest_id);

        
        $servicerequest->status = ServiceStatusEnum::RELEASED->value;
        $executionofservice->datereleased = date('Y-m-d');
        $executionofservice->rating = $rating;
        $servicerequest->save();
        $executionofservice->save();
        return redirect()->action([WorkOrderController::class, 'listxrelease']); 
    }


    public function listxapprove(Request $request){
        $initialdate =  $request->initialdate ?? (date('Y')."-01-01");
        $finaldate =  $request->finaldate ?? date('Y-m-d');

        $rol = $request->session()->get('rol')??"0";

        if ($rol != RolEnum::APPROVER->value){
            $data = [
                'message' =>  "Operación no permitida",
                'success' => false,
                'urldestination'=>'window.history.back();'
            ];
            return view ('message', compact('data'));
        }
        $executionofservices = \DB::table('executionofservice as ES')
        ->leftjoin('hardware as H','ES.hardware_id','=','H.hardware_id')
        ->leftjoin('user as A','ES.email','=','A.email')
        ->leftjoin('servicerequest as SR','ES.servicerequest_id','=','SR.servicerequest_id')
        ->leftjoin('user as U','SR.email','=','U.email')  
        ->leftjoin('user as AP','ES.approved','=','AP.email')   
        ->leftjoin('servicetype as ST','ES.servicetype_id','=','ST.servicetype_id')
        ->where('SR.status','=', ServiceStatusEnum::RELEASED->value)
        ->where('ES.dateofservice','>=',$initialdate)
        ->where('ES.dateofservice','<=',$finaldate)
        ->where('U.email','like','%')
        ->select('ES.executionofservice_id','ES.servicerequest_id','SR.folio','SR.daterequest',
            'ES.dateofservice','U.name as requester','ES.actions','ES.materialsused',
            'ES.datereleased','ES.dateapproved','A.name as whoperformedtheservice',
            'SR.status','H.features as hardware',
            'ES.internalservice','ST.description as servicetype','AP.name as approved')
        ->get();

        if (count($executionofservices)<=0){
            $data = [
                'message' =>  "No hay órdenes de trabajo de mantenimiento pendientes por aprobar",
                'success' => false,
                'urldestination'=>'window.location.href="/dashboards"'
            ];
            return view ('message', compact('data'));
        }
        $executionofservices = PaginateCollection::paginate($executionofservices, 10);
        return view('workorder.listxapprove',compact('executionofservices','rol'));

    }

    public function approve(Request $request){
        $rol = $request->rol_id;
        $executionofservice_id = $request->executionofservice_id;
        $servicerequest_id = $request->servicerequest_id;
        $approver = $request->session()->get('email');

        $executionofservice = Executionofservice::find($executionofservice_id);
        $servicerequest = Servicerequest::find($servicerequest_id);
        
        $servicerequest->status = ServiceStatusEnum::APPROVED->value;
        $executionofservice->dateapproved = date('Y-m-d');
        $executionofservice->approved = $approver;
        
        $servicerequest->save();
        $executionofservice->save();

        return redirect()->action([WorkOrderController::class, 'listxapprove']); 
    }


}
