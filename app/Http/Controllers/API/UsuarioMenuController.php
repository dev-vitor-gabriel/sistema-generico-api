<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RelUsuarioMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UsuarioMenuController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_menu_usm' => 'required|array',
            'id_menu_usm.*' => 'required|int|exists:tb_menu,id_menu_mnu',
            'id_user' => 'required|int|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $existingRecords = RelUsuarioMenu::where('id_user', $request->id_user)
        ->whereIn('id_menu_usm', $request->id_menu_usm)
        ->pluck('id_menu_usm')
        ->toArray();

        $newRecords = array_diff($request->id_menu_usm, $existingRecords);

        $rel_usuario_menus = [];
        foreach ($newRecords as $menu_id) {
            $rel_usuario_menus[] = RelUsuarioMenu::create([
                'id_menu_usm' => $menu_id,
                'id_user' => $request->id_user
            ]);
        }

        return response()->json($rel_usuario_menus, 201);
    }

}
