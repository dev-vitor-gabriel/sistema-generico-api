<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\RelFuncionarioTipoServico;
use Illuminate\Http\Request;


class FuncionarioController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'id_funcionario_cargo_tfu' => 'required|int|max:255',
            'desc_funcionario_tfu' => 'required|string|max:255',
            'documento_funcionario_tfu' => 'required|string|max:255',
            'telefone_funcionario_tfu' => 'required|string|max:255',
            'endereco_funcionario_tfu' => 'required|string|max:255'
        ]); 

        $funcionario = Funcionario::create([
            'id_funcionario_cargo_tfu' => $request->id_funcionario_cargo_tfu,
            'desc_funcionario_tfu' => $request->desc_funcionario_tfu,
            'documento_funcionario_tfu' => $request->documento_funcionario_tfu,
            'telefone_funcionario_tfu' => $request->telefone_funcionario_tfu,
            'endereco_funcionario_tfu' => $request->endereco_funcionario_tfu
        ]);
        if($request->tipos_servico){
            foreach ($request->tipos_servico as $tipo_servico) {
                RelFuncionarioTipoServico::create([
                    'id_funcionario_rft' => $funcionario->id,
                    'id_tipo_servico_rft' => $tipo_servico['value']
                ]);
            }
        }

        return response()->json($funcionario,201);
    }

    public function get(Int $id_funcionario = null) {
        if($id_funcionario){
            $data = Funcionario::getById(($id_funcionario));
            return $data;
        }
        $data = Funcionario::getAll();

        $input_array = $data->toArray();

        $data = $this->groupByTypeService($input_array);
        return $data;
    }

    public function update(Int $id_funcionario, Request $request) {
        $request->validate([
            'id_funcionario_cargo_tfu' => 'required|int|max:255',
            'desc_funcionario_tfu' => 'required|string|max:255',
            'documento_funcionario_tfu' => 'required|string|max:255',
            'telefone_funcionario_tfu' => 'required|string|max:255',
            'endereco_funcionario_tfu' => 'required|string|max:255'
        ]);
        Funcionario::updateReg($id_funcionario, $request);

        $funcionarioData = Funcionario::getById($id_funcionario);
        
        $input_array = $funcionarioData->toArray();
        

        $funcionarioData = $this->groupByTypeService($input_array);

        if($request->tipos_servico){
            $tipoServicoRemove = [];
            $tipoServicoNew = [];
            $tipoServicoAlreadyRegistered = $funcionarioData[0]['tipos_servico'];
            foreach ($tipoServicoAlreadyRegistered as $key => $old) {
                $exists = false;
                foreach ($request->tipos_servico as $key => $new) {
                    if ($old['id_servico_tipo_stp'] == $new['value']) {
                        $exists = true;
                        break;
                    }
                }
                if ($exists == false) {
                    $tipoServicoRemove[] = $old;
                }
            }

            $tipoServicoNew = array_filter($request->tipos_servico, function ($reg) use ($tipoServicoAlreadyRegistered) {
                foreach ($tipoServicoAlreadyRegistered as $value) {
                    if ($value['id_servico_tipo_stp'] == $reg['value'])
                        return false;
                }
                return true;
            });
            foreach ($tipoServicoNew as $tipo_servico) {
                RelFuncionarioTipoServico::create([
                    'id_funcionario_rft' => $id_funcionario,
                    'id_tipo_servico_rft' => $tipo_servico['value']
                ]);
            }
            foreach ($tipoServicoRemove as $tipo_servico) {
                $relFuncionarioTipoServico = RelFuncionarioTipoServico::where('id_funcionario_rft', $id_funcionario)
                ->where('id_tipo_servico_rft', $tipo_servico['id_servico_tipo_stp'])
                ->first();

                $delete = RelFuncionarioTipoServico::where('id_rel_rft', $relFuncionarioTipoServico->id_rel_rft)->first();

                $delete->delete();
            }
        }
    }

    public function delete(Int $id_funcionario) {
        Funcionario::deleteReg($id_funcionario);
    }

    private function groupByTypeService($input_array){
        // variavel de saida
        $output_array = [];

        // agrupa materiais e tipos de servico por servico
        foreach ($input_array as $item) {
            $id = $item['id_funcionario_tfu'];
            if (!isset($output_array[$id])) {
                $output_array[$id] = [...$item,
                    'tipos_servico' => [],
                ];
                unset($output_array[$id]['id_servico_tipo_stp']);
                unset($output_array[$id]['des_servico_tipo_stp']);
            }

            if ($item['id_servico_tipo_stp'] !== null) {
                $temp = array_filter($output_array[$id]['tipos_servico'], function ($reg) use($item) { return $reg['id_servico_tipo_stp'] == $item['id_servico_tipo_stp']; });
                if(count($temp) == 0) {
                    $output_array[$id]['tipos_servico'][] = [
                        "id_servico_tipo_stp" => $item['id_servico_tipo_stp'],
                        "des_servico_tipo_stp" => $item['des_servico_tipo_stp'],
                    ];
                }
            }
        }

        // Converte o array associativo em um array indexado
        $output_array = array_values($output_array);
        return $output_array;
    }
}
