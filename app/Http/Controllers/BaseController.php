<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController
{

    protected string $classe;
    /**
     * Methodo para retornar todas as Series cadastradas
     * @return Entidade $entity;
     */
    public function index(Request $request)
    {
        // Implementar a paginação:

        return $this->classe::paginate($request->per_page);

        // Definindo o Offset:
        // $offset = ($request->page - 1) * $request->per_page;
        // $recursos = $this->classe::query()
        //                     ->offset($offset) // Determina uma paginação das series limitadas pelo Limit
        //                     ->limit($request->per_page) // Determina a quantidade de series que serão retornadas
        //                     ->get(); // Retorna os dados dessa cosulta
        // if (isset($recursos))
        // {
        //     return response()
        //             ->json('', 204);
        // }
        //return response()->json($recursos);


        // retornar atraves do bando
        // return $this->classe::all())
    }

    public function store(Request $request)
    {
        return response()
                ->json( 
                    $this->classe::create($request->all()),
                    201
                );
    }

    public function show(int $id)
    {
        $recursos = $this->classe::find($id);
        if( is_null($recursos) )
        {
            // Retornar o status 204 de requisição sem conteudo
            return response()->json('', 204);
        }
        
        return response()->json($recursos);
    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->classe::find($id);
        if ( is_null($recurso) )
        {
            return response()->json(
                ['error' => 'Resurso não encontrado'],
                404
            );
        }

        $recurso->fill($request->all());
        $recurso->save();

        return $recurso;
    }

    public function destroy(int $id)
    {
        $qtd = $this->classe::destroy($id);
        if ( $qtd === 0 )
        {
            return response()->json(
                ['error' => 'Nenhum recurso removido'],
                404
            );
        }

        return response()->json('', 204);
    }
}