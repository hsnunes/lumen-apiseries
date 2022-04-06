<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    public function gerarToken(Request $request)
    {
        // Validar os dados email e password com o validade
        $this->validate($request,[
            "email" => "required|email",
            "password" => "required"
        ]);
        // Consultar os dados passados e validados
        $usuario = User::where('email', $request->email)->first();

        // Verificando a Senha com o methodo HASH::check()
        // Hash::check($request->email, $usuario->email);

        // Autenticar o usuario restringindo o acesso
        if ( is_null($usuario) 
             || !Hash::check($request->password, $usuario->password)
        )
        {
            return response()->json("Usuario ou senha invalidos", 401);
        }

        // Gerar o Token
        // A linha do Email é o Payload
        $token = JWT::encode(
            ["email" => $request->email],
            env('JWT_KEY'),
            "HS256"
        );

        return ["access_token" => $token];
    }
}