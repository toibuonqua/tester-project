<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admincodestar extends Model
{
    use HasFactory;

    protected $table = 'admincodestar';

    protected $fillable = [
        'id',
        'username',
        'password',
        'email',
        'phone_number',
        'workarea_id',
        'code_user',
        'role_id',
        'department_id',
        'manager_id',
        'status'
    ];

    protected $hidden = [     // giấu field không hiển thị khi lấy array
        'password',
    ];

    const DEFAULT_EMAIL = "admincodestar@gmail.com";
    const DEFAULT_PASSWORD = "codestar@123";
    const DEFAULT_USERNAME = "Admin CodeStar";
    const DEFAULT_STATUS = "active";
    const DEFAULT_CODE_USER = 2019;
    const DEFAULT_PHONE_NUMBER = 1000000000;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function workarea()
    {
        return $this->belongsTo(Workarea::class);
    }

}
