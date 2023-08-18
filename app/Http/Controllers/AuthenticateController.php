<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Rol;
use App\Models\Menu;
use App\Models\Roluser;
use App\Models\Servicerequest;
use App\Enums\ServiceStatusEnum;
use App\Enums\RolEnum;
use Illuminate\Support\Facades\Auth;
use App\Utils\Menu as MenuOptions;

class AuthenticateController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
      
    public function customLogin(Request $request)
    {
        $validatedData= $request->validate([
            'email' => 'required|email:rfc',
            'password' => 'required',
        ]);
   
        if (Auth::attempt($validatedData)) {    
                   
              
            
            $user = User::select('name','estatus')
            ->where("email", "=", $request->email)
            ->first();
            if ($user->estatus==1){
                $request->session()->put('email', $request->email);
                $request->session()->put('username', $user->name);
            
                $roluser= Roluser::select("rol_id")
                            ->where("email", "=", $request->email)
                            ->first();
                $request->session()->put('rol', $roluser->rol_id);

                $menu= Menu::select("menu")
                        ->where("rol_id","=",$roluser->rol_id)
                        ->first();

                $menu =  MenuOptions::generateInHTMLTag(json_decode($menu->menu));
                
                $request->session()->put('menu', $menu);

                return redirect("/dashboards");
            }else {
                return redirect("login")->with('error','Credenciales de acceso incorrectos');
            }
        }
  
        return redirect("login")->with('error','Credenciales de acceso incorrectos');
    }

    public function registration()
    {
        $roles =  Rol::all();
        return view('auth.registration', compact("roles"));
    }

    public function registerrequest()
    {
        return view('auth.registration_requester');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        
        $check = $this->create($data);

        //--- insert in userrol
        $rolUser = ["rol_id"=>$data['rol_id'],
            "email"=>$data['email']
        ];

        Roluser::create($rolUser);
        
        if ($rolUser==RolEnum::REQUESTER->value)
            return redirect("login");
        else 
            return redirect("dashboards");
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
