<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

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
