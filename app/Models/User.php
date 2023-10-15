<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'url_img_user',
        'is_ativo_user'
    ];

    public static function getAll() {
        $data = User::select(['name','email','url_img_user'])->where('is_ativo_user', 1)->orderBy('id', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = User::select(['name','email','url_img_user'])->where('id', $id)->where('is_ativo_user', 1)->orderBy('id', 'desc')->get();
        }else{
            $data = User::select(['name','email','url_img_user'])->where('is_ativo_user', 1)->orderBy('id', 'desc')->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id, $obj) {
        User::where('id', $id)
        ->update([
            'name'         => $obj->name,
            'email'        => $obj->email,
            'password'     => Hash::make($obj->password),
            'url_img_user' => $obj->url_img_user
        ]);
    }

    public static function deleteReg($id) {
        User::where('id', $id)
        ->update([
            'is_ativo_user' => 0
        ]);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
