<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'desc_cargo_tcg' => 'required|string|max:255'
        ]); 

        $cargo = Cargo::create([
            'desc_cargo_tcg' => $request->desc_cargo_tcg
        ]);

        return response()->json($cargo,201);
    }

    public function get(Int $id_cargo = null) {
        if($id_cargo){
            $data = Cargo::getById(($id_cargo));
            return $data;
        }
        $data = Cargo::getAll();
        return $data;
    }

    public function update(Int $id_cargo, Request $request) {
        $request->validate([
            'desc_cargo_tcg' => 'required|string|max:255'
        ]);
        Cargo::updateReg($id_cargo, $request);
    }

    public function delete(Int $id_cargo) {
        Cargo::deleteReg($id_cargo);
    }

}
