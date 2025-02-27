<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RelEmpresaMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaMenuController extends Controller
{

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_menu_emn' => 'required|array',
            'id_menu_emn.*' => 'required|int|exists:tb_menu,id_menu_mnu',
            'id_empresa_emn' => 'required|int|exists:tb_empresa,id_empresa_emp'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $existingRecords = RelEmpresaMenu::where('id_empresa_emn', $request->id_empresa_emn)
        ->whereIn('id_menu_emn', $request->id_menu_emn)
        ->pluck('id_menu_emn')
        ->toArray();

        $newRecords = array_diff($request->id_menu_emn, $existingRecords);

        $rel_empresa_menu = [];
        foreach ($newRecords as $menu_id) {
            $rel_empresa_menu[] = RelEmpresaMenu::create([
                'id_menu_emn'    => $menu_id,
                'id_empresa_emn' => $request->id_empresa_emn
            ]);
        }

        return response()->json($rel_empresa_menu, 201);
    }

    public function getMenuByIdEmpresa(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $data = RelEmpresaMenu::getMenuByIdEmpresa($id_empresa);

        return response()->json($data);
    }
}
