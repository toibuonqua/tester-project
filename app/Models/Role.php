<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $fillable = ['id', 'name'];

    public function accounts()
    {
        return $this->hasMany(Accounts::class);
    }

    public function admincodestar()
    {
        return $this->hasMany(Admincodestar::class);
    }
    
}
