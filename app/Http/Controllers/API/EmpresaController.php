<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {

        $request->merge([
            'cnpj_empresa_emp' => preg_replace('/\D/', '', $request->cnpj_empresa_emp)
        ]);

        $messages = [
            'des_empresa_emp.required' => 'Nome da Empresa é obrigatório.',
            'razao_social_empresa_emp.required' => 'Razão Social é obrigatório.',
            'cnpj_empresa_emp.required' => 'CNPJ é obrigatório.',
            'des_endereco_emp.required' => 'Endereço é obrigatório.',
            'des_cidade_emp.required' => 'Cidade é obrigatório.',
            'des_cep_emp.required' => 'CEP é obrigatório.',
            'des_tel_emp.required' => 'Telefone é obrigatório.',
        ];

        $rules = [
            'des_empresa_emp' => 'required|string|max:255',
            'razao_social_empresa_emp' => 'required|string|max:255',
            'cnpj_empresa_emp' => ['required', 'string', 'size:14', function ($attribute, $value, $fail) {
                if (!Empresa::validateCNPJ($value)) {
                    $fail('O CNPJ informado é inválido.');
                }
                if (Empresa::where('cnpj_empresa_emp', $value)->exists()) {
                    $fail('O CNPJ informado já está cadastrado.');
                }
            }],
            'des_endereco_emp' => 'required|string|max:255',
            'des_cidade_emp' => 'required|string|max:255',
            'des_cep_emp' => 'required|string|max:9',
            'des_tel_emp' => 'required|string|max:20',
            'lnk_whatsapp_emp' => 'nullable|url',
            'lnk_instagram_emp' => 'nullable|url',
            'lnk_facebook_emp' => 'nullable|url',
            'img_empresa_emp' => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $empresa = Empresa::create([
            'des_empresa_emp' => $request->des_empresa_emp,
            'razao_social_empresa_emp' => $request->razao_social_empresa_emp,
            'cnpj_empresa_emp' => $request->cnpj_empresa_emp,
            'des_endereco_emp' => $request->des_endereco_emp,
            'des_cidade_emp' => $request->des_cidade_emp,
            'des_cep_emp' => $request->des_cep_emp,
            'des_tel_emp' => $request->des_tel_emp,
            'lnk_whatsapp_emp' => $request->lnk_whatsapp_emp,
            'lnk_instagram_emp' => $request->lnk_instagram_emp,
            'lnk_facebook_emp' => $request->lnk_facebook_emp,
            'img_empresa_emp' => $request->img_empresa_emp,
        ]);

        return response()->json(['message' => 'Empresa criada com sucesso.', 'empresa' => $empresa], 201);
    }

    /**
     * Display the specified resource.
     */
    public function getAll(Request $request)
    {
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);

        return Empresa::getAll($per_page, $page_number, $filter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
