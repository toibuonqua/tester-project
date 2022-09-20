<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultPassword extends Model
{
    use HasFactory;

    protected $table = 'defaultpassword';

    protected $fillable = ['id', 'password'];

    const DEFAULT_PASSWORD = "12345678";

    public function defaultPassword()
    {
        return $this->first()->password;
    }
}
