<?php

namespace App\Http\Controllers\API;

use App\Enums\OrigemStatusEnum;
use App\Enums\StatusVendaEnum;
use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\Funcionario;
use App\Models\RelVendaMaterial;
use App\Models\Material;
use App\Models\Status;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\MaterialMovimentacaoController;
use App\Interfaces\EstoqueItemRepositoryInterface;
use App\Interfaces\VendaRepositoryInterface;

class VendaController extends Controller
{
    public function __construct(private MaterialMovimentacaoController $materialMovimentacaoController, private EstoqueItemRepositoryInterface $estoqueItemRepository, private VendaRepositoryInterface $vendaRepository)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->materialMovimentacaoController = $materialMovimentacaoController;
        $this->estoqueItemRepository = $estoqueItemRepository;
    }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function getIdUser(Request $request) {
        $id_usuario = (int)$request->header('id-usuario-d');

        return $id_usuario;
    }

    // create
    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);
        $id_usuario = $this->getIdUser($request);

        $funcionario = Funcionario::getById($id_empresa,$request->id_funcionario_vda);

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
        //     id_status_vda,
        //     materiais: [
        //         { id_material_rvm,  vlr_unit_material_rvm, qtd_material_rvm  }
        //     ]
        // }

        $centroCusto = CentroCusto::getById($id_usuario,$request->id_centro_custo_vda);

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
                'id_status_vda' => $request->id_status_vda,
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
                    'id_estoque_item_eti' => $material_venda['id_estoque_item_eti'],
                    ]
                );
        }

        $status = Status::getById($request->id_status_vda);
            if ($status->status_sts == StatusVendaEnum::Finalizada->value) {

                $saldoInsuficiente = $this->validarSaldo($request->materiais, $request->id_centro_custo_vda, $id_empresa);

                if (!empty($saldoInsuficiente)) {
                    $mensagem = "Saldo insuficiente para os seguintes materiais:";
                    foreach ($saldoInsuficiente as $item) {
                        $mensagem .= "\n- Material ID: {$item['id_material']}, Quantidade disponível: {$item['qtd_disponivel']}, Quantidade requerida: {$item['qtd_requerida']}";
                    }

                    DB::rollBack();
                    return response()->json([
                        'message' => $mensagem
                    ], 422);
                }

                $movimentacaoRequest = new Request([
                    'id_centro_custo_mov' => $request->id_centro_custo_vda,
                    'materiais' => array_map(function ($material) {
                        return [
                            'id_material_mte' => $material['id_material_rvm'],
                            'qtd_material_mit' => $material['qtd_material_rvm'],
                        ];
                    }, $request->materiais),
                    'des_estoque_item_eti' => 'Venda (Saída)',
                ]);
                $movimentacaoRequest->headers->set('id-empresa-d', $id_empresa);

                $this->materialMovimentacaoController->create($movimentacaoRequest, 'saida');
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

        $per_page = $request->query('per_page', 10);
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;
        return Venda::get($id_empresa, $id_venda, $filter, $per_page, $page_number);
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


        $data = $request->only(['id_funcionario_vda', 'id_centro_custo_vda', 'id_cliente_ser', 'desc_venda_vda', 'id_status_vda' ]);

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

        if (!$data['id_status_vda'])
        {
            return response()->json([
                'error' => 'Status é um campo obrigatório.'
            ], 400);
        }

        $venda = Venda::get($id_empresa, $id_venda, null);

        if (!$venda)
        {
            return response()->json([
                'error' => 'Venda não encontrada.'
            ], 400);
        }

       $status = Status::getById($venda->id_status_vda);
       if ($status->status_sts == StatusVendaEnum::Finalizada->value)
       {
           return response()->json([
               'error' => 'A venda já foi finalizada e não pode ser alterada.'
           ], 400);
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
            'id_status_vda'       => $request->id_status_vda,
            'id_centro_custo_vda' => $request->id_centro_custo_vda,
            'id_funcionario_vda'  => $request->id_funcionario_vda,
            'id_cliente_vda'      => $request->id_cliente_vda,
        ]);

        $novoStatus = Status::getById($request->id_status_vda);
        if (
            $novoStatus->status_sts == StatusVendaEnum::Cancelada->value &&
            $status->status_sts == StatusVendaEnum::Finalizada->value
        ) {
            $movimentacaoRequest = new Request([
                'id_centro_custo_mov' => $venda->id_centro_custo_vda,
                'materiais' => array_map(function ($material) {
                    return [
                        'id_material_mte' => $material['id_material_rvm'],
                        'qtd_material_mit' => $material['qtd_material_rvm'],
                    ];
                }, $materiaisAtuais),
                'des_estoque_item_eti' => 'Venda (Cancelamento)',
            ]);
            $movimentacaoRequest->headers->set('id-empresa-d', $id_empresa);
            $this->materialMovimentacaoController->create($movimentacaoRequest, 'entrada');
        }

        if (
            $status->status_sts != StatusVendaEnum::Finalizada->value &&
            $novoStatus->status_sts == StatusVendaEnum::Finalizada->value
        ) {
            $saldoInsuficiente = $this->validarSaldo($materiaisAtuais, $request->id_centro_custo_vda, $id_empresa);

            if (!empty($saldoInsuficiente)) {
                $mensagem = "Saldo insuficiente para os seguintes materiais:";
                foreach ($saldoInsuficiente as $item) {
                    $mensagem .= "\n- Material ID: {$item['id_material']}, Quantidade disponível: {$item['qtd_disponivel']}, Quantidade requerida: {$item['qtd_requerida']}";
                }

                DB::rollBack();
                return response()->json([
                    'message' => $mensagem
                ], 422);
            }

            $movimentacaoRequest = new Request([
                'id_centro_custo_mov' => $venda->id_centro_custo_vda,
                'materiais' => array_map(function ($material) {
                    return [
                        'id_material_mte' => $material['id_material_rvm'],
                        'qtd_material_mit' => $material['qtd_material_rvm'],
                    ];
                }, $materiaisAtuais),
                'des_estoque_item_eti' => 'Venda (Saída)',
            ]);
            $movimentacaoRequest->headers->set('id-empresa-d', $id_empresa);
            $this->materialMovimentacaoController->create($movimentacaoRequest, 'saida');
        }

        DB::commit();

        return response()->json([
            'message' => 'Venda atualizada com sucesso.'
        ], 201);
    }

    public function finalizar(Int $id_venda, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $origem = OrigemStatusEnum::Venda->value;
        $status = StatusVendaEnum::Finalizada->value;
        $status = Status::getByOrigemStatus($origem, $status);
        $venda = Venda::get($id_empresa, $id_venda, null);

        $materiaisAtuais = RelVendaMaterial::getByIdVenda($id_venda);

        $saldoInsuficiente = $this->validarSaldo($materiaisAtuais, $venda->id_centro_custo_vda, $id_empresa);

        if (!empty($saldoInsuficiente)) {
            $mensagem = "Saldo insuficiente para os seguintes materiais:";
            foreach ($saldoInsuficiente as $item) {
                $mensagem .= "\n- Material ID: {$item['id_material']}, Quantidade disponível: {$item['qtd_disponivel']}, Quantidade requerida: {$item['qtd_requerida']}";
            }

            DB::rollBack();
            return response()->json([
                'message' => $mensagem
            ], 422);
        }

        $movimentacaoRequest = new Request([
            'id_centro_custo_mov' => $venda->id_centro_custo_vda,
            'materiais' => array_map(function ($material) {
                return [
                    'id_material_mte' => $material['id_material_rvm'],
                    'qtd_material_mit' => $material['qtd_material_rvm'],
                ];
            }, $materiaisAtuais),
            'des_estoque_item_eti' => 'Venda (Saída)',
        ]);
        $movimentacaoRequest->headers->set('id-empresa-d', $id_empresa);
        $this->materialMovimentacaoController->create($movimentacaoRequest, 'saida');

        Venda::atualizarStatus($id_empresa, $id_venda, $status->id_status_sts);
  }

    public function cancelar(Int $id_venda, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $origem = OrigemStatusEnum::Venda->value;
        $status = StatusVendaEnum::Cancelada->value;
        $status = Status::getByOrigemStatus($origem, $status);
        $venda = Venda::get($id_empresa, $id_venda, null);
        Venda::atualizarStatus($id_empresa, $id_venda, $status->id_status_sts);

        $materiaisAtuais = RelVendaMaterial::getByIdVenda($id_venda);

        $movimentacaoRequest = new Request([
            'id_centro_custo_mov' => $venda->id_centro_custo_vda,
            'materiais' => array_map(function ($material) {
                return [
                    'id_material_mte' => $material['id_material_rvm'],
                    'qtd_material_mit' => $material['qtd_material_rvm'],
                ];
            }, $materiaisAtuais),
            'des_estoque_item_eti' => 'Venda (Cancelamento)',
        ]);
        $movimentacaoRequest->headers->set('id-empresa-d', $id_empresa);
        $this->materialMovimentacaoController->create($movimentacaoRequest, 'entrada');

    }
    private function validarSaldo($materiais, $id_centro_custo, $id_empresa)
    {
        $saldoInsuficiente = [];

        foreach ($materiais as $material) {
            $estoqueItem = $this->estoqueItemRepository->getByCentroCustoMaterial(
                $id_centro_custo,
                $material['id_material_rvm']
            );

            if (!$estoqueItem || $estoqueItem->qtd_estoque_item_eti < $material['qtd_material_rvm']) {
                $saldoInsuficiente[] = [
                    'id_material' => $material['id_material_rvm'],
                    'qtd_disponivel' => $estoqueItem->qtd_estoque_item_eti ?? 0,
                    'qtd_requerida' => $material['qtd_material_rvm'],
                ];
            }
        }

        return $saldoInsuficiente;
    }

    public function getTotalMateriaisPorVenda(Request $request)
    {
        $centrosCusto = explode(',', $request->query('centros_custo'));
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');

        $data = $this->vendaRepository->getTotalMateriaisPorVenda($centrosCusto,$dataInicio,$dataFim);

        return response()->json($data);
    }
}
