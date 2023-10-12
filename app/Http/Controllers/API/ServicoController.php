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
    public function create(Request $request)
    {
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

        foreach ($request->tipos_servico as $tipo_servico) {
            if (isset($tipo_servico['vlr_tipo_servico_rst'])) {
                $value = $tipo_servico['vlr_tipo_servico_rst'];
            } else {
                $value = ServicoTipo::select(['vlr_servico_tipo_stp'])->where('id_servico_tipo_stp', $tipo_servico['id_servico_tipo_stp'])->get()[0]->vlr_servico_tipo_stp;
            }

            RelServicoTipoServico::create([
                'id_servico_rst'                    => $servico->id,
                'id_tipo_servico_rst'               => $tipo_servico['id_servico_tipo_stp'],
                'vlr_tipo_servico_rst'              => $value
            ]);
        }

        foreach ($request->materiais as $material) {
            if (isset($material['vlr_material_rsm'])) {
                $valueMaterial = $material['vlr_material_rsm'];
            } else {
                $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
            }

            $valueQtdMaterial = 1;
            if (isset($material['qtd_material_rsm'])) {
                $valueQtdMaterial = $material['qtd_material_rsm'];
            }

            RelServicoMaterial::create([
                'id_servico_rsm'                    => $servico->id,
                'id_material_rsm'                   => $material['id_material_mte'],
                'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                'qtd_material_rsm'                  => $valueQtdMaterial
            ]);
        }

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $servico
        ]);
    }
    // get
    public function get(Int $id_servico = null)
    {

        $data = Servico::get($id_servico);

        $input_array = $data->toArray();

        $data = $this->groupServiceByTypeServiceAndMaterial($input_array);


        // return $data;
        return response()->json($data);
    }

    // update
    // todo: ajustar
    public function update(Int $id_servico, Request $request)
    {
        $request->validate([
            'txt_servico_ser'               => 'string|max:255',
            'vlr_servico_ser'               => 'integer',
            'dta_agendamento_ser'           => 'date_format:Y-m-d H:i:s',
            'id_centro_custo_ser'           => 'integer',
            'id_funcionario_servico_ser'    => 'integer',
            'id_cliente_ser'                => 'integer',
        ]);

        $data = $request->only(['txt_servico_ser', 'vlr_servico_ser', 'dta_agendamento_ser', 'id_centro_custo_ser', 'id_funcionario_servico_ser', 'id_cliente_ser']);
        $servico = Servico::updateReg($id_servico, $data);


        $serviceData = Servico::get($id_servico);

        $input_array = $serviceData->toArray();

        if($request->tipos_servico || $request->materiais){
            $serviceData = $this->groupServiceByTypeServiceAndMaterial($input_array);
            
            if($request->tipos_servico){
                $tipoServicoRemove = [];
                $tipoServicoUpdate = [];
                $tipoServicoNew = [];
                $tipoServicoAlreadyRegistered = $serviceData[0]['tipos_servico'];
                foreach ($tipoServicoAlreadyRegistered as $key => $old) {
                    $exists = false;
                    foreach ($request->tipos_servico as $key => $new) {
                        if($old['id_servico_tipo_stp'] == $new['id_servico_tipo_stp']){
                            if($old['vlr_tipo_servico_rst'] != $new['vlr_tipo_servico_rst']){
                                $tipoServicoUpdate []=$new;
                            }
                            $exists = true;
                            break;
                        }

                    }
                    if($exists == false){
                        $tipoServicoRemove []=$old;
                    }
                }
                
                $tipoServicoNew = array_filter($request->tipos_servico, function($reg) use ($tipoServicoAlreadyRegistered) { 
                    foreach ($tipoServicoAlreadyRegistered as $value){ 
                        if($value['id_servico_tipo_stp'] == $reg['id_servico_tipo_stp'])
                            return false;
                    }
                    return true;
                });

          

                foreach ($tipoServicoNew as $tipo_servico) {
                    if (isset($tipo_servico['vlr_tipo_servico_rst'])) {
                        $value = $tipo_servico['vlr_tipo_servico_rst'];
                    } else {
                        $value = ServicoTipo::select(['vlr_servico_tipo_stp'])->where('id_servico_tipo_stp', $tipo_servico['id_servico_tipo_stp'])->get()[0]->vlr_servico_tipo_stp;
                    }

                    RelServicoTipoServico::create([
                        'id_servico_rst'                    => $id_servico,
                        'id_tipo_servico_rst'               => $tipo_servico['id_servico_tipo_stp'],
                        'vlr_tipo_servico_rst'              => $value
                    ]);
                }
                foreach ($tipoServicoUpdate as $tipo_servico) {
                    if (isset($tipo_servico['vlr_tipo_servico_rst'])) {
                        $value = $tipo_servico['vlr_tipo_servico_rst'];
                    } else {
                        $value = ServicoTipo::select(['vlr_servico_tipo_stp'])->where('id_servico_tipo_stp', $tipo_servico['id_servico_tipo_stp'])->get()[0]->vlr_servico_tipo_stp;
                    }

                    RelServicoTipoServico::where('id_servico_rst', $id_servico)
                    ->where('id_tipo_servico_rst', $tipo_servico['id_servico_tipo_stp'])
                    ->update([
                        'vlr_tipo_servico_rst'              => $value
                    ]);
                }

                foreach ($tipoServicoRemove as $tipo_servico) {
                    RelServicoTipoServico::where('id_servico_rst', $id_servico)
                    ->where('id_tipo_servico_rst', $tipo_servico['id_servico_tipo_stp'])
                    ->delete();
                }
            }

            if($request->materiais){
                $materialRemove = [];
                $materialUpdate = [];
                $materialNew = [];
                $materialAlreadyRegistered = $serviceData[0]['materiais'];
                foreach ($materialAlreadyRegistered as $key => $old) {
                    $exists = false;
                    foreach ($request->materiais as $key => $new) {
                        if($old['id_material_mte'] == $new['id_material_mte']){
                            if($old['vlr_material_rsm'] != $new['vlr_material_rsm'] || $old['qtd_material_rsm'] != $new['qtd_material_rsm']){
                                $materialUpdate []=$new;
                            }
                            $exists = true;
                            break;
                        }

                    }
                    if($exists == false){
                        $materialRemove []=$old;
                    }
                }
                
                $materialNew = array_filter($request->materiais, function($reg) use ($materialAlreadyRegistered) { 
                    foreach ($materialAlreadyRegistered as $value){ 
                        if($value['id_material_mte'] == $reg['id_material_mte'])
                            return false;
                    }
                    return true;
                });

                // novos
                foreach ($materialNew as $material) {
                    if (isset($material['vlr_material_rsm'])) {
                        $valueMaterial = $material['vlr_material_rsm'];
                    } else {
                        $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
                    }

                    $valueQtdMaterial = 1;
                    if (isset($material['qtd_material_rsm'])) {
                        $valueQtdMaterial = $material['qtd_material_rsm'];
                    }

                    RelServicoMaterial::create([
                        'id_servico_rsm'                    => $id_servico,
                        'id_material_rsm'                   => $material['id_material_mte'],
                        'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                        'qtd_material_rsm'                  => $valueQtdMaterial
                    ]);
                }

                // update
                foreach ($materialUpdate as $material) {
                    if (isset($material['vlr_material_rsm'])) {
                        $valueMaterial = $material['vlr_material_rsm'];
                    } else {
                        $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
                    }

                    $valueQtdMaterial = 1;
                    if (isset($material['qtd_material_rsm'])) {
                        $valueQtdMaterial = $material['qtd_material_rsm'];
                    }

                    RelServicoMaterial::where('id_servico_rsm', $id_servico)
                    ->where('id_material_rsm', $material['id_material_mte'])
                    ->update([
                        'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                        'qtd_material_rsm'                  => $valueQtdMaterial
                    ]);
                }

                // delete
                foreach ($materialRemove as $material) {
                    RelServicoMaterial::where('id_servico_rsm', $id_servico)
                    ->where('id_material_rsm', $material['id_material_mte'])
                    ->delete();
                }
            }
        }

        return response()->json([
            'message' => 'Service updated successfully'
        ]);
    }
    private function groupServiceByTypeServiceAndMaterial($input_array){
        // variavel de saida
        $output_array = [];

        // agrupa materiais e tipos de servico por servico
        foreach ($input_array as $item) {
            $id = $item['id_servico_ser'];
            if (!isset($output_array[$id])) {
                $output_array[$id] = [...$item,
                    'materiais' => [],
                    'tipos_servico' => [],
                ];
                unset($output_array[$id]['id_material_mte']);
                unset($output_array[$id]['des_material_mte']);
                unset($output_array[$id]['vlr_material_rsm']);
                unset($output_array[$id]['qtd_material_rsm']);
                unset($output_array[$id]['id_servico_tipo_stp']);
                unset($output_array[$id]['des_servico_tipo_stp']);
                unset($output_array[$id]['vlr_tipo_servico_rst']);
            }

            if ($item['id_material_mte'] !== null) {
                $temp = array_filter($output_array[$id]['materiais'], function ($reg) use($item) { return $reg['id_material_mte'] == $item['id_material_mte']; });
                if(count($temp) == 0) {
                    $output_array[$id]['materiais'][] = [
                        "id_material_mte" => $item['id_material_mte'],
                        "des_material_mte" => $item['des_material_mte'],
                        "vlr_material_rsm" => $item['vlr_material_rsm'],
                        "qtd_material_rsm" => $item['qtd_material_rsm']
                    ];
                }
            }
            if ($item['id_servico_tipo_stp'] !== null) {
                $temp = array_filter($output_array[$id]['tipos_servico'], function ($reg) use($item) { return $reg['id_servico_tipo_stp'] == $item['id_servico_tipo_stp']; });
                if(count($temp) == 0) {
                    $output_array[$id]['tipos_servico'][] = [
                        "id_servico_tipo_stp" => $item['id_servico_tipo_stp'],
                        "des_servico_tipo_stp" => $item['des_servico_tipo_stp'],
                        "vlr_tipo_servico_rst" => $item['vlr_tipo_servico_rst']
                    ];
                }
            }
        }

        // Converte o array associativo em um array indexado
        $output_array = array_values($output_array);
        return $output_array;
    }
}
