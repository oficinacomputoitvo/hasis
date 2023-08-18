<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\RolEnum;
use App\Models\Servicerequest;
use App\Models\Executionofservice;
use App\Enums\ServiceStatusEnum;

class DashboardController extends Controller
{
    private function servicePending($initialDate, $finalDate){
        $totalRequestPending = Servicerequest::where('status',ServiceStatusEnum::INPROCESS->value)
        ->where("daterequest",">=",$initialDate)
        ->where("daterequest","<=",$finalDate)
        ->count();
        return $totalRequestPending;
    }

    private function servicePendingForApprove($initialDate, $finalDate){
        $totalPendingForApprove = Servicerequest::where('status',ServiceStatusEnum::RELEASED->value)
        ->where("daterequest",">=",$initialDate)
        ->where("daterequest","<=",$finalDate)
        ->count();
        return $totalPendingForApprove;
    }

    private function serviceFinished($initialDate, $finalDate){

        $serviceFinished = Servicerequest::select(\DB::raw("substr(Monthname(daterequest),1,3) as meses"), 
            \DB::raw("COUNT(*) as total"))
            ->where('daterequest','>=',$initialDate)
            ->where('daterequest','<=',$finalDate)
            ->where('status','>=',ServiceStatusEnum::ATTENDED->value)
            ->where('status','<',ServiceStatusEnum::CANCELLED->value)
            ->groupBy('meses')
            ->orderBy(\DB::raw("Month(daterequest)"), 'ASC')
            ->get();
            return $serviceFinished;

    }
    private function qualityOfService ($initialDate, $finalDate){
        $qualityOfService = \DB::table('executionofservice')
            ->where('dateofservice','>=',$initialDate)
            ->where('dateofservice','<=',$finalDate)
            ->groupBy('rating')
            ->select(\DB::raw("if(rating=1,'Malo',if(rating=2,'Regular',if(rating=3,'Bueno',if(rating=4,'Muy bueno','Excelente')))) as name"),\DB::raw("COUNT(*) as y"))
            ->get();

        return $qualityOfService;
    }

    private function statusHardware(){
        $statusHardware = \DB::table('hardware as H')
        ->leftjoin('status as S','S.status_id','=','H.status_id')
        ->groupBy('S.description')
        ->select('S.description as name',\DB::raw("COUNT(*) as y"))
        ->get();
        return $statusHardware;
    }

    public function showAdmin($request){
        $initialDate = $request->get("initialdate")?? date('Y-01-01');
        $finalDate = $request->get("finaldate")?? date('Y-m-d');

        $totalRequestPending = $this->servicePending($initialDate, $finalDate);
        $qualityOfService = $this->qualityOfService($initialDate, $finalDate);
        $serviceFinished = $this->serviceFinished($initialDate, $finalDate);
        $statusHardware =  $this->statusHardware();
        $totalPendingForApprove = $this->servicePendingForApprove($initialDate, $finalDate);

        return view ("dashboard.administrator",
            compact("totalRequestPending",
                "initialDate","finalDate",
                "qualityOfService",
                "serviceFinished",
                "statusHardware",
                "totalPendingForApprove",
        ));
    }

    public function showRequester($request){
        $initialDate = $request->get("initialdate")?? date('Y-01-01');
        $finalDate = $request->get("finaldate")?? date('Y-m-d');
        $email = $request->session()->get('email',"");

        $pendingRequestsXRelease = \DB::table('executionofservice as ES')
        ->leftjoin('hardware as H','ES.hardware_id','=','H.hardware_id')
        ->leftjoin('user as A','ES.email','=','A.email')
        ->leftjoin('servicerequest as SR','ES.servicerequest_id','=','SR.servicerequest_id')
        ->leftjoin('user as U','SR.email','=','U.email')  
        ->leftjoin('user as AP','ES.approved','=','AP.email')   
        ->leftjoin('servicetype as ST','ES.servicetype_id','=','ST.servicetype_id')
        ->where('SR.status','=', ServiceStatusEnum::ATTENDED->value)
        ->where('ES.dateofservice','>=',$initialDate)
        ->where('ES.dateofservice','<=',$finalDate)
        ->where('U.email','=',$email)
        ->select('ES.executionofservice_id','ES.servicerequest_id','SR.folio','SR.daterequest',
            'ES.dateofservice','U.name as requester','ES.actions','ES.materialsused',
            'ES.datereleased','ES.dateapproved','A.name as whoperformedtheservice',
            'SR.status','H.features as hardware',
            'ES.internalservice','ST.description as servicetype','AP.name as approved')
        ->get()->count(); 

        return view ("dashboard.requester", compact("pendingRequestsXRelease"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $rol = $request->session()->get("rol")?? 0;

        if ($rol <= 0 || $rol > RolEnum::APPROVER->value){
            return redirect("/login");
        }
        if ($rol <= RolEnum::COLLABORATOR->value || 
            $rol == RolEnum::APPROVER->value 
        ){
            return $this->showAdmin($request);
        } else if ($rol <= RolEnum::REQUESTER->value){
            return $this->showRequester($request);
        } 

    }

}
