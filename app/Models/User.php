<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAccess;
use App\Models\Module;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'wina_m_user';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    const CREATED_AT = 'dt_record';
    const UPDATED_AT = 'dt_modified';

    protected $fillable = [
        'username',
        'password',
        'email',
        'name',
        'gender',
        'user_type',
        'join_date',
        'is_login',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public static function getLogin($username)
    {
        $model = self::where('username', $username)->first();
        $model->user_access = UserAccess::where('user_id', $model->user_id)->get();
        $model->menu_name = Module::select('wina_m_module.module_name', 'wina_m_module.module_id', 'parent.module_name as parent_name')
            ->join('wina_m_module AS parent', 'parent.module_id', 'wina_m_module.parent_id')
            ->join('wina_m_module_function', 'wina_m_module.module_id', 'wina_m_module_function.module_id')
            ->join('wina_m_user_access', 'wina_m_module_function.module_function_id', 'wina_m_user_access.module_function_id')
            ->where('wina_m_user_access.user_id', $model->user_id)->distinct()->get()->keyBy('module_id');
        return $model;
    }

    public function user_access()
    {
        return $this->hasMany('App\Models\UserAccess', 'user_id', 'user_id');
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public static function getByID($id)
    {
        $model = self::find($id);

        return $model;
    }

    public static function getByUsername($username)
    {
        $model = self::where('username', $username)->first();

        return $model;
    }

    public static function updatePassword($id, $password)
    {
        $model = self::find($id);
        $model->password = Hash::make($password);
        $model->user_access = UserAccess::where('user_id', $model->user_id)->get();

        return $model;
    }

    // public static function getPopulate(){
    //     $model = self::select('wina_m_user.email','wina_m_user.username','wina_m_user.user_id','wina_m_user.status','wina_m_user_type.user_type_name')
    //                 ->join('wina_m_user_type', 'wina_m_user_type.user_type_id', 'wina_m_user.user_type_id');
    //     return $model;
    // }

    public static function resetPassword($id, $password)
    {
        $model = self::find($id);
        $model->password = Hash::make($password);
        $model->save();

        return $model;
    }
}
