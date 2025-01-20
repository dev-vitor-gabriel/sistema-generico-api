<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\Funcionario;
use App\Models\Material;
use App\Models\Venda;
use Illuminate\Http\Request;
use RelVendaMaterial;

class VendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    // create
    public function create(Request $request)
    {
        $funcionario = Funcionario::getById($request->id_funcionario_vda);

        if (!$funcionario)
        {
            return response()->json([
                'message' => 'Insira um funcionário válido.'
            ]);
        }

        // {
        //     id_funcionario_vda,
        //     id_centro_custo_vda,
        //     id_cliente_ser,
        //     desc_venda_vda,
        //     materiais: [
        //         { id_material_rvm,  vlr_unit_material_rvm, qtd_material_rvm  }
        //     ]
        // }

        $centroCusto = CentroCusto::getById($request->id_centro_custo_vda);

        if (!$centroCusto)
        {
            return response()->json([
                'message' => 'Insira um centro custo válido.'
            ]);
        }


        $venda = Venda::create(
            [
                'id_funcionario_vda' => $request->id_funcionario_vda,
                'desc_venda_vda' => $request->desc_venda_vda,
                'id_centro_custo_vda' => $request->id_centro_custo_vda,
            ]
        );

        foreach($request->materiais as $material_venda)
        {
            RelVendaMaterial::create(
                    [
                    'id_venda_rvm' => $venda->id,
                    'id_material_rvm' => $material_venda['id_material_rvm'],
                    'vlr_unit_material_rvm' => $material_venda['vlr_unit_material_rvm'],
                    'qtd_material_rvm' => $material_venda['qtd_material_rvm'],
                    ]
                );
        }


        return response()->json([
            'message' => 'Venda criada com sucesso!',
        ]);
    }

    // get
    public function get(Request $request, Int $id_venda = null)
    {
        $Venda = new Venda();
        $filter = $request->only($Venda->getFillable());

        $filter = array_filter($filter, function($reg){ return mb_strtoupper($reg) != "NULL";});
        $data = Venda::get($id_venda, $filter);

        return response()->json($data);
    }

}
