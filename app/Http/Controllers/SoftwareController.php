<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\Classification;
use App\Models\Licencetype;
use App\Utils\PaginateCollection;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $softwares = \DB::table('software as S')
        ->leftJoin('classification as C', 'S.classification_id', '=', 'C.classification_id')
        ->leftJoin('licencetype as L', 'S.licencetype_id', '=', 'L.licencetype_id')
        ->orderBy('S.name', 'ASC')
        ->select('S.software_id','C.description AS classification','L.description as licencetype','S.name','S.version','S.licence')
        ->get();
        $softwares = PaginateCollection::paginate($softwares, 5);
        
        return view ('software.list',compact("softwares"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classifications=Classification::orderBy('description')->get();
        $licencetypes=Licencetype::orderBy('description')->get();
        return view ('software.create' ,compact("classifications","licencetypes"));
    }
    private function save (Request $request,$id=0){
        $request->validate([
            'name' => ['required', 'string'],
           
        ]);
        if  (intval($id)==0){
            $software = new Software();
        }
        else {
             $software =  Software::find($id);
        }
        
        $software->name =  $request->name;
        $software->classification_id = $request->classification_id;
        $software->licencetype_id = $request->licencetype_id;
        $software->version = $request->version;
        $software->licence = $request->licence;
        $software->save();
       
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ],['name.required'=>"El campo nombre es necesario"]);

        $data = ["name"=>$request->name,
                "version"=>$request->version,
                "licence"=>"".$request->licence,
                "classification_id"=> $request->classification_id,
                "licencetype_id"=>$request->licencetype_id
        ];

        $software = Software::create($data);
        return redirect('/softwares');

        
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
        $software = Software::find($id); 
        $licencetypes = Licencetype::all();
        $classifications = Classification::all();
        return view ("software.edit", compact("software","licencetypes","classifications"));
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
        return redirect("softwares")->with('success','Guardado correctamente');
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
