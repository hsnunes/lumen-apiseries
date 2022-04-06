<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class Autenticador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {

        try {

            // Verificar se o Header Authorization está sendo passado
            if ( !$request->hasHeader('Authorization') )
            {
                throw new \Exception();
            }

            // Limpar o atributo Authorization para pegar somente o token
            $authorizationHeader = $request->header('Authorization');

            $token = str_replace('Bearer ', '', $authorizationHeader);
            // Validar o Token na Funcção JWT - Retorna uma exceção caso algo errado
            $dadosAutenticacao = JWT::decode($token, env('JWT_KEY'), ['HS256']);

            // Autenticar o Usuario na base
            $user = User::where(
                            'email', $dadosAutenticacao->email
                        )
                        ->first();
            if ( is_null($user) ) {
                throw new \Exception();
            }

            return $next($request);

        } catch (\Exception $e) {
            return response()->json(
                'Não autorizado', 401
            );
        }

    }
}
