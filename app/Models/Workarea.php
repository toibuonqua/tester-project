<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workarea extends Model
{
    use HasFactory;

    protected $table = 'workarea';

    protected $fillable = ['id', 'name', 'work_areas_code'];

    const DEFAULT_STATUS = 'ok';

    protected $attributes = [
        'status' => self::DEFAULT_STATUS,
    ];

    public function accounts()
    {
        return $this->hasMany(Accounts::class);
    }
}
