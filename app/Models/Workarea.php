<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workarea extends Model
{
    use HasFactory;

    protected $table = 'workarea';

    protected $fillable = ['id', 'name', 'work_areas_code', 'createrId', 'created_at', 'updated_at'];

    const DEFAULT_STATUS = 'active';
    const DEFAUL_PAGINATION = 5;

    protected $attributes = [
        'status' => self::DEFAULT_STATUS,
    ];

    public function accounts()
    {
        return $this->hasMany(Accounts::class);
    }

    public function createrAccount()
    {
        return $this->belongsTo(Accounts::class, 'createrId', 'id');
    }

}
