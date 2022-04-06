<?php

namespace App\Http\Controllers;

use App\Serie;
use App\Http\Controllers\BaseController;

class SeriesController extends BaseController
{

    public function __construct()
    {
        $this->classe = Serie::class;
    }

}