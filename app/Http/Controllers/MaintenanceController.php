<?php

namespace App\Http\Controllers;

use PDF;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Maintenanceschedule;
use App\Models\Template;
use App\Enums\RolEnum;
use App\Utils\PaginateCollection;


class MaintenanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $maintenances = \DB::table('maintenanceschedule as M')
        ->leftJoin('user as U', 'M.whoelaborated', '=', 'U.email')
        ->orderBy('M.schoolcycle', 'DESC')
        ->orderBy('M.year', 'DESC')
        ->select('M.maintenanceschedule_id','M.schoolcycle','M.year',
            'U.name as whoelaborated','M.dateofpreparation','M.whoautorized',
            'M.dateofapproval')
        ->get();
        $maintenances = PaginateCollection::paginate($maintenances, 5);
        
        return view ('maintenance.list',compact("maintenances"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id =  $request->maintenanceschedule_id??0;

        $users = \DB::table('user as U')
        ->leftJoin('roluser as R', 'U.email', '=', 'R.email')
        ->whereIn('rol_id', [RolEnum::ADMIN->value, RolEnum::COLLABORATOR->value, RolEnum::APPROVER->value])
        ->orderBy('U.name', 'ASC')
        ->select('U.email','U.name')
        ->get();

        $schoolcycle = "";
        $year="";
        $maintenanceschedule = Maintenanceschedule::find($id );
        if ($maintenanceschedule){
            $schoolcycle  = $maintenanceschedule->schoolcycle;
            $year = $maintenanceschedule->year;
        }
        

        return view ('maintenance.create', compact('users','id','schoolcycle','year'));
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function preview(Request $request){

        $maintenanceschedule_id = $request->maintenanceschedule_id??0;

        if ( $maintenanceschedule_id>0 && isset($request->schoolcycle) && 
            isset($request->whoautorized) && 
            isset($request->dateofapproval) ) {
            $dataMaintenance= [
                "schoolcycle"=>$request->schoolcycle,
                "year"=>$request->year,
                "whoelaborated"=>$request->whoelaborated,
                "dateofpreparation"=>$request->dateofpreparation,
                "dateofapproval"=>$request->dateofapproval,
                "whoautorized"=>$request->whoautorized
            ];
            Maintenanceschedule::find($maintenanceschedule_id)->update($dataMaintenance);
        }
        


        $maintenancesSchedule = \DB::table('maintenanceschedule as MS')
            ->leftjoin('user as U','MS.whoelaborated','=','U.email')
            ->leftjoin('maintenancescheduleservice as MSS','MS.maintenanceschedule_id','=', 'MSS.maintenanceschedule_id')
            ->leftjoin('maintenancescheduleservicedetail as MSSD','MSS.maintenancescheduleservice_id','MSSD.maintenancescheduleservice_id')
            ->where('MS.maintenanceschedule_id','=',$maintenanceschedule_id)
            ->orderBy('MSS.number','ASC')
            ->get();

        $data = [
            'date' => date('m/d/Y'),
            'maintenanceschedule' => $maintenancesSchedule,
            'template'=>Template::find(1)
        
        ]; 
        
        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf = PDF::loadView('maintenance.preview', $data );
        $pdf->set_paper('letter', 'landscape');

        return $pdf->stream('maintenances.pdf');
        
       

    }
}
