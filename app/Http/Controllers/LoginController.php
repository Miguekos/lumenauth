<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function login( Request $req ){
        // validacion del request	
        $this->validate( $req, [
          'email' => 'email|required',
          'password' => 'required'
        ]);
          
        // consulta del usuario
        $user = User::query()->where('email', $req->input('email') )->first();
          
        // verificaion de contraseña
        if( Crypt::decrypt( $user->password ) === $req->input('password') ){
              
          // creamos un string random para el token
          $token = str_random(50);
          
          // le seteamos el api_token al usuario
          $user->api_token = $token;
      
          // guardamos
          $user->save();
              
          // retornamos el api_token, para futuras peticiones
          return response()->json(['status' => 'success','api_token' => $token]);
        }else{
      
          return response()->json(['status' => 'fail'],401);
        }
      
      }

      public function logout(Request $req){
        User::where('api_token', $req->input('api_token'))->update(['api_token' => null]);
        return response()->json(['status' => 'success']);
      }


    //
}
