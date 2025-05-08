<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\FinanceiroRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceiroController extends Controller
{
    public function __construct(
        private FinanceiroRepositoryInterface $FinanceiroRepository
     )
     {
     }

    public function getIdEmpresa(Request $request) 
    {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'desc_financeiro_fin'     => 'required|string|max:255',
            'vlr_financeiro_fin'      => 'required|integer|min:0',
            'tipo_transacao_fin'      => 'required|in:0,1', // 0 = entrada, 1 = saída
            'id_empresa_fin'          => 'required|exists:tb_empresa,id_empresa_emp',
            'id_centro_custo_fin'     => 'required|exists:tb_centro_custo,id_centro_custo_cco',
            'id_referencia_fin'       => 'nullable|integer',
            'tipo_referencia_fin'     => 'required|in:0,1,2,3', // 0 = manual, 1 = venda, 2 = serviço, 3 = compra, etc.
            'is_ativo_fin'            => 'boolean',
        ]);


        if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
        }

        $request = $request->merge(['id_empresa_fin' => $id_empresa]);

        $movimentacao_financeira = $this->FinanceiroRepository->create($request->all());


        return response()->json($movimentacao_financeira,201);
    }
}
