<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Não autorizado',
            ], 401);
        }

        $user = Auth::user();
        $menu = Menu::getAll();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'menu' => $menu
        ]);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            'url_img_user' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filePath = null;
        if ($request->hasFile('url_img_user')) {
            $filePath = $request->file('url_img_user')->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'url_img_user' => $filePath
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'user' => $user
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }



    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Desconectado com sucesso',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function get(Int $id_user = null) {
        if($id_user){
            $data = User::getById(($id_user));
            return $data;
        }
        $data = User::getAll();
        return $data;
    }

    public function update(Int $id, Request $request) {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            'url_img_user' => 'string'
        ]);
        User::updateReg($id, $request);
    }

    public function delete(Int $id) {
        User::deleteReg($id);
    }
}
