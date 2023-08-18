<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receptionofrequest;
use App\Models\Servicerequest;

use App\Utils\PaginateCollection;

class ReceptionOfRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        
        $servicerequests = \DB::table('servicerequest as SR')
            ->leftjoin('user as U','SR.email','=','U.email')
            ->where('SR.status','=', 1)
            ->select('SR.servicerequest_id','SR.daterequest','SR.folio','U.name as username',
                'SR.daterequest','SR.description')
            ->get();
            
        $servicerequests = PaginateCollection::paginate($servicerequests, 2);
        $today = date('Y-m-d');
        $email = $request->session()->get('email');
        return view ('receptionrequest.list', compact('servicerequests','today','email'));
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
        //
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
