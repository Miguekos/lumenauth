<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  { }

    /**
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $req)
  {

          // validamos los datos
          $validator = $this->validate($req, [
              'name' => 'required',
              'email' => 'email|required',
              'password' => 'required'
          ]);


          $nuevapass = Crypt::encrypt( $req['password'] );
          $validar_json = ([
              "name" => $req->name,
              "email" => $req->email,
              "password" => $nuevapass,
          ]);

          $usuario = User::create($validar_json);
          return response()->json($usuario, 201);


  }

  //
}
