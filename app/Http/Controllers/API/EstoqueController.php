<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{

    public function get(Int $id_estoque = null) {
        if($id_estoque){
            $data = Estoque::getById(($id_estoque));
            return $data;
        }
        $data = Estoque::getAll();
        return $data;
    }

}
