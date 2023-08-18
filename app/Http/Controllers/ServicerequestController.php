<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Hardware;
use App\Models\Servicerequest;
use App\Models\Servicerequesthardware;
use App\Models\Template;
use App\Enums\RolEnum;
use App\Enums\ServiceStatusEnum;
use PDF;
use Illuminate\Support\Facades\DB;

use App\Utils\PaginateCollection;
use App\Http\Controllers\MailController;

use Illuminate\Support\Facades\Session;

class ServicerequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $status = $request->get('status') ?? "%";

        $initialdate =  $request->get('initialdate')?? (date('Y')."-01-01");
        $finaldate =  $request->get('finaldate')??date('Y-m-d');
  
        $email ="" ;

        if (Session::has('email')){
            $email =  Session::get('email');
        }
        

        
        $servicerequests =  \DB::table('servicerequest as SR')
        ->where('SR.email','=',$email )
        ->where("SR.status",'like',$status)
        ->where('SR.daterequest','>=', $initialdate )
        ->where('SR.daterequest','<=', $finaldate )
        ->orderBy('SR.daterequest', 'DESC')
        ->get();
        

        
        if (count($servicerequests)>=1){
            $servicerequests = PaginateCollection::paginate($servicerequests, 10);
            return view ('servicerequest.list',compact('servicerequests','status','initialdate'));
        } else {
            $url = 'window.location.href="/servicerequests"';
            if ($status=="%"){
                $url = 'window.location.href="/dashboards"';
            }
            $data = [
                'success'=>false,
                'message'=> "No hay datos coincidentes",
                'urldestination'=>$url,
            ];
            return view ('message',compact('data'));
        }
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $email = "";
        if (Session::has('email')){
            $email = Session::get('email');
        }
        $users =  \DB::table('user as U')
        ->leftJoin('roluser as R', 'U.email', '=', 'R.email')
        ->where('R.rol_id','=',RolEnum::REQUESTER->value)
        ->where('U.email','=',$email)
        ->orderBy('U.name', 'ASC')
        ->select('U.email','U.name')
        ->get();

        $hardwares = \DB::table('hardware as H')
        ->leftJoin('assignment as A', 'H.hardware_id', '=', 'A.hardware_id')
        ->where('A.email','=',$email)
        ->orderBy('H.features', 'ASC')
        ->select('H.hardware_id','H.features')
        ->get();

        $result = \DB::select('SELECT folio(?) as folio', ['servicerequest']);
        $folio = $result[0]->folio;


        return view ("servicerequest.create", compact('users','hardwares','folio'));
    }

    private function validateData(Request $request){
        $request->validate([
            'email' => 'required|email|exists:user,email',
            'hardware' => 'required',
            'daterequest' => 'required|date',
            'description' => 'required|string'
        ],[
            'email.required' => 'Es necesario indicar el solicitante',
            'hardware.required' => 'Debe seleccionar al menos un equipo',
            'daterequest.required' => 'Es necesario indicar la fecha de elaboración',
            'description.required' => 'Es necesario indicar la falla o el servicio'
        ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData($request);
        
        $dataServiceRequest = ['folio'=>$request->folio,
            'email'=>$request->email,
            'description'=>$request->description,
            'daterequest'=>$request->daterequest
        ];

        DB::beginTransaction();
        $serviceRequest =  Servicerequest::create($dataServiceRequest);

        $hardwareIds = $request->hardware;
        foreach($hardwareIds as $hardwareId) {
            $servicerequesthardware = new Servicerequesthardware();
            $servicerequesthardware->servicerequest_id = $serviceRequest->servicerequest_id;
            $servicerequesthardware->hardware_id = $hardwareId;
            $servicerequesthardware->save();
        }
        DB::commit();

        $mailController = new MailController();

        $content = ["message"=>$request->description,
            "username"=>$request->session()->get('username')
        ];
        $mailController->send( "request",
            "Solicitud de mantenimiento correctivo",
            $content);
        return redirect("/servicerequests/preview/$serviceRequest->servicerequest_id");
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
        $email = "";
        if (Session::has('email')){
            $email = Session::get('email');
        }
        $users =  \DB::table('user as U')
        ->leftJoin('roluser as R', 'U.email', '=', 'R.email')
        ->where('R.rol_id','=',RolEnum::REQUESTER->value)
        ->where('U.email','=',$email)
        ->orderBy('U.name', 'ASC')
        ->select('U.email','U.name')
        ->get();

        $hardwares = \DB::table('hardware as H')
        ->leftJoin('assignment as A', 'H.hardware_id', '=', 'A.hardware_id')
        ->where('A.email','=',$email)
        ->orderBy('H.features', 'ASC')
        ->select('H.hardware_id','H.features')
        ->get();

        $hardwaresSelected = \DB::table('servicerequesthardware as SRH')
        ->leftjoin('hardware as H','H.hardware_id','=','SRH.hardware_id')
        ->where('SRH.servicerequest_id','=', $id)
        ->select('H.hardware_id')
        ->get();


        $hardwaresPreselected = [];

        foreach($hardwaresSelected  as $hardwareSelected){
            $hardwaresPreselected [] = $hardwareSelected->hardware_id;
        }

        $servicerequest =  Servicerequest::find($id);

        if ($servicerequest)      
            return view ("servicerequest.edit", 
            compact('users','hardwares','servicerequest', 'hardwaresPreselected'));
        else {
            $data = [
                'success'=>false,
                'message'=>"No se encontró el dato a editar",
                'urldestination' =>"window.history.back();"
            ];
            return view('message', compact('data'));
        }
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
        $this->validateData($request);
        $id = intval($id);
        $dataServiceRequest = ['folio'=>$request->folio,
            'email'=>$request->email,
            'description'=>$request->description,
            'daterequest'=>$request->daterequest
        ];
        DB::beginTransaction();
        $servicerequest = Servicerequest::find($id)->update($dataServiceRequest);

        Servicerequesthardware::where('servicerequest_id','=',$id)->delete();
        
        $hardwareIds = $request->hardware;
        foreach($hardwareIds as $hardwareId) {
            $servicerequesthardware = new Servicerequesthardware();
            $servicerequesthardware->servicerequest_id = $id;
            $servicerequesthardware->hardware_id = $hardwareId;
            $servicerequesthardware->save();
        }
        DB::commit();

        $mailController = new MailController();

        $content = ["message"=>$request->description,
            "username"=>$request->session()->get('username')
        ];
        $mailController->send( "request",
            "Solicitud de mantenimiento correctivo",
            $content);
        return redirect("/servicerequests/preview/$id");

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

    public function cancel(Request $request)
    {
        
        $folio = intval($request->get('folio')??0);
        $servicerequest_id = intval($request->get('servicerequest_id')??1);
        
        Servicerequest::where('servicerequest_id','=',$servicerequest_id)
        ->where('folio','=',$folio)
        ->update(['status'=>ServiceStatusEnum::CANCELLED->value]);
        $data = [
            'success'=>true,
            'message'=> "El folio $folio fue cancelado ",
            'urldestination'=>'window.location.href="/dashboards"'
        ];
        return view('message', compact('data'));
        
    }

    public function getArea($hardware_id){
        $area = \DB::table('assignment as S')
            ->leftjoin('area as A','A.area_id','=','S.area_id')
            ->where('S.hardware_id','=',$hardware_id)
            ->select('A.description')
            ->first();
        return $area->description;
    }

    public function preview($id){
        
        $servicerequest_id = intval($id);

        $hardwaresThatWasServiced = \DB::table('hardware as H')
            ->leftjoin('servicerequesthardware as SH', 'H.hardware_id','=','SH.hardware_id')
            ->where('SH.servicerequest_id','=',$servicerequest_id)
            ->select('H.hardware_id','H.features','H.inventorynumber')
            ->get();
        
        if (count($hardwaresThatWasServiced)<=0){
            return redirect("/dashboards");
        }
        $areaDescription =  $this->getArea($hardwaresThatWasServiced[0]->hardware_id);

        $servicerequest = \DB::table('servicerequest as SR')
            ->leftjoin('user as U','SR.email','=','U.email')
            ->where('SR.servicerequest_id','=', $servicerequest_id)
            ->select('SR.servicerequest_id','SR.daterequest','SR.folio','U.name as username',
                'SR.daterequest','SR.description',\DB::raw("'$areaDescription' as area")  ,'SR.status')
            ->first();

            $data = [
            'date' => date('m/d/Y'),
            'servicerequest' => $servicerequest,
            'hardwaresrepaired' => $hardwaresThatWasServiced,
            'template'=>Template::find(1)
        
        ]; 
        
        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf = PDF::loadView('servicerequest.preview', $data );
        $pdf->set_paper('letter', 'portrait');

        return $pdf->stream('solicitud.pdf');
    }
}
