<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\Funcionario;
use App\Models\Material;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RelVendaMaterial;

class VendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    // create
    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

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
                'error' => 'Insira um centro custo válido.'
            ]);
        }

        $venda = Venda::create(
            [
                'id_funcionario_vda' => $request->id_funcionario_vda,
                'id_cliente_vda' => $request->id_cliente_vda,
                'desc_venda_vda' => $request->desc_venda_vda,
                'id_centro_custo_vda' => $request->id_centro_custo_vda,
                'id_empresa_vda' => $id_empresa,
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
        $id_empresa = $this->getIdEmpresa($request);

        $Venda = new Venda();
        $filter = $request->only($Venda->getFillable());

        $filter = array_filter($filter, function($reg){ return mb_strtoupper($reg) != "NULL";});
        $data = Venda::get($id_empresa, $id_venda, $filter);

        return response()->json($data);
    }

    // get materiais
    public function getMateriais(Request $request, Int $id_venda = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $Venda = new Venda();
        $filter = $request->only($Venda->getFillable());

        $filter = array_filter($filter, function($reg){ return mb_strtoupper($reg) != "NULL";});
        $data = Venda::getMateriais($id_empresa, $id_venda, $filter);

        return response()->json($data);
    }

    // put
    public function update(Int $id_venda, Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);
        // {
        //     id_funcionario_vda,
        //     id_centro_custo_vda,
        //     id_cliente_ser,
        //     desc_venda_vda,
        //     materiais: [
        //         { id_material_rvm,  vlr_unit_material_rvm, qtd_material_rvm  }
        //     ]
        // }


        $data = $request->only(['id_funcionario_vda', 'id_centro_custo_vda', 'id_cliente_ser', 'desc_venda_vda' ]);

        if (!$data['id_funcionario_vda'])
        {
            return response()->json([
                'error' => 'Funcionário é um campo obrigatório.'
            ], 400);
        }

        if (!$data['id_centro_custo_vda'])
        {
            return response()->json([
                'error' => 'Centro de Custo é um campo obrigatório.'
            ], 400);
        }

        $venda = Venda::get($id_venda, null);

        if (!$venda)
        {
            return response()->json([
                'error' => 'Venda não encontrada.'
            ], 400);
        }

        if ($venda->id_status_venda == 3)
        {

        }

        $materiaisExcluir = $request->input('idsMateriaisExcluir');
        $materiaisAtualizar = $request->input('materiaisAtualizar');
        $materiaisInserir = $request->input('materiaisInserir');

        DB::beginTransaction();

        if (!empty($materiaisExcluir)) {
            foreach ($materiaisExcluir as $id) {
                RelVendaMaterial::where('id', $id)->delete();
            }
        }

        if (!empty($materiaisInserir))
        {
            foreach($request->materiaisInserir as $material_venda)
            {
                RelVendaMaterial::create(
                        [
                        'id_venda_rvm' => $id_venda,
                        'id_material_rvm' => $material_venda['id_material_rvm'],
                        'vlr_unit_material_rvm' => $material_venda['vlr_unit_material_rvm'],
                        'qtd_material_rvm' => $material_venda['qtd_material_rvm'],
                        ]
                    );
            }
        }

        if (!empty($materiaisAtualizar))
        {

            foreach($request->materiaisAtualizar as $material_venda)
            {
                RelVendaMaterial::updateReg($material_venda["id"],
                        [
                        'id_venda_rvm' => $id_venda,
                        'id_material_rvm' => $material_venda['id_material_rvm'],
                        'vlr_unit_material_rvm' => $material_venda['vlr_unit_material_rvm'],
                        'qtd_material_rvm' => $material_venda['qtd_material_rvm'],
                        ]
                    );
            }
        }

        $materiaisAtuais = RelVendaMaterial::getByIdVenda($id_venda);

        if (empty($materiaisAtuais))
        {
            DB::rollBack();
            return response()->json([
                'error' => 'A venda deverá ter ao menos um material.'
            ], 400);
        }

        Venda::updateReg($id_empresa, $id_venda, [
            'desc_venda_vda'      => $request->desc_venda_vda,
            'id_centro_custo_vda' => $request->id_centro_custo_vda,
            'id_funcionario_vda'  => $request->id_funcionario_vda,
            'id_cliente_vda'      => $request->id_cliente_vda,
        ]);

        DB::commit();

        return response()->json([
            'error' => 'Venda atualizada com sucesso.'
        ], 201);
    }

    public function finalizar(Request $request, Int $id_venda) {
        $id_empresa = $request->header('id_empresa');

        Venda::finalizarReg($id_empresa, $id_venda);
    }

}
