<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_has_role extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
    ];

    public function userName()
    {
        return $this->hasOne(User::class, 'id', 'model_id');
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'model_id');
    }


}