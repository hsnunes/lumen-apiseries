<?php

namespace App\Providers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            if (!$request->hasHeader('Authorization')) {
                return null;
            }
            // Recebe os dados enviador pelo HEADER, selecionando a chave Authorization
            $authorizationHeader = $request->header('Authorization');
            // Limpa a chave Authorization, removendo a string 'Bearer ' e deixando apenas o token
            $token = str_replace('Bearer ', '', $authorizationHeader);

            // Tratar com a Lib JWT::decode() / Retorna o email;
            $dadosAutenticacao = JWT::decode($token, env("JWT_KEY"), ["HS256"]);

            // var_dump($dadosAutenticacao);exit;

            // retornar primeiramente um User generico para testes
            // return new GenericUser(['email' => $dadosAutenticacao]);

            // Email foi o dado passado para a autenticação, por isso será avaliado
            return User::where( 'email', $dadosAutenticacao->email )->first();
        });
    }
}
