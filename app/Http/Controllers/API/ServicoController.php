<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Servico;
use App\Models\RelServicoTipoServico;
use App\Models\RelServicoMaterial;
use App\Models\Material;
use App\Models\ServicoTipo;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    // create
    public function create(Request $request) {
        $request->validate([
            'txt_servico_ser'               => 'required|string|max:255',
            'vlr_servico_ser'               => 'required|integer',
            'dta_agendamento_ser'           => 'required|date_format:Y-m-d H:i:s',
            'id_centro_custo_ser'           => 'required|integer',
            'id_funcionario_servico_ser'    => 'required|integer',
            'id_cliente_ser'                => 'required|integer',
        ]);

        $servico = Servico::create([
            'txt_servico_ser'               => $request->txt_servico_ser,
            'vlr_servico_ser'               => $request->vlr_servico_ser,
            'dta_agendamento_ser'           => $request->dta_agendamento_ser,
            'id_centro_custo_ser'           => $request->id_centro_custo_ser,
            'id_funcionario_servico_ser'    => $request->id_funcionario_servico_ser,
            'id_cliente_ser'                => $request->id_funcionario_servico_ser,
            'is_ativo_ser'                  => 1,
        ]);

        foreach($request->tipo_servico as $tipo_servico){
            if (isset($tipo_servico['custom']) && isset($tipo_servico['custom']['value'])){
                $value = $tipo_servico['custom']['value'];
            }
            else{
                $value = ServicoTipo::select(['vlr_servico_tipo_stp'])->where('id_servico_tipo_stp', $tipo_servico['value'])->get()[0]->vlr_servico_tipo_stp;
            }

            RelServicoTipoServico::create([
                'id_servico_rst'                    => $servico->id,
                'id_tipo_servico_rst'               => $tipo_servico['value'],
                'vlr_tipo_servico_rst'              => $value
            ]);
        }

        foreach($request->material as $material){
            $vlr_material = [...array_filter($material['custom'] , function($reg){return $reg['column'] == 'vlr_material_mte';})];
            if(isset($vlr_material[0])){
                $valueMaterial = $vlr_material[0]['value'];
            }else{
                $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['value'])->get()[0]->vlr_material_mte;
            }

            $qtd_material = [...array_filter($material['custom'] , function($reg){return $reg['column'] == 'qtd_material_mte';})];
            $valueQtdMaterial = 1;
            if(isset($qtd_material[0])){
                $valueQtdMaterial = $qtd_material[0]['value'];
            }

            RelServicoMaterial::create([
                'id_servico_rsm'                    => $servico->id,
                'id_material_rsm'                   => $material['value'],
                'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                'qtd_material_rsm'                  => $valueQtdMaterial
            ]);
        }

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $servico
        ]);
    }
}
