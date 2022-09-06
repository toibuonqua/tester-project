<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workarea extends Model
{
    use HasFactory;

    protected $table = 'workarea';

    protected $fillable = ['id', 'name', 'work_areas_code'];

    const DEFAUL_PAGINATION = 5;

    // protected $attributes = [

    // ];

    public function accounts()
    {
        return $this->hasMany(Accounts::class);
    }
}
