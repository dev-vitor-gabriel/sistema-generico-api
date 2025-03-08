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

        $empresaId = $request->id_empresa_emn;
        $menusEnviados = $request->id_menu_emn;

        $existingRecords = RelEmpresaMenu::where('id_empresa_emn', $empresaId)
            ->pluck('id_menu_emn')
            ->toArray();

        $menusParaRemover = array_diff($existingRecords, $menusEnviados);
        RelEmpresaMenu::where('id_empresa_emn', $empresaId)
            ->whereIn('id_menu_emn', $menusParaRemover)
            ->delete();

        $menusParaAdicionar = array_diff($menusEnviados, $existingRecords);
        $rel_empresa_menu = [];
        foreach ($menusParaAdicionar as $menu_id) {
            $rel_empresa_menu[] = RelEmpresaMenu::create([
                'id_menu_emn'    => $menu_id,
                'id_empresa_emn' => $empresaId
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
