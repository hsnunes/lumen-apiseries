<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Http\Controllers\BaseController;

class EpisodiosController extends BaseController
{

    public function __construct()
    {  
        $this->classe = Episodio::class;
    }

    public function buscaPorSerie(Int $id)
    {
        $epis = $this->classe::query()
                ->where('serie_id', $id)
                ->paginate();
        return $epis;
    }

}