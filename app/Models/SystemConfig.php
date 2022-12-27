<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    use HasFactory;

    protected $table = 'systemconfig';

    protected $fillable = ['id', 'password'];

    const DEFAULT_PASSWORD = "12345678";

    // TODO: need upgrade in future
    public function getdefaultPassword()
    {
        $dfpw = SystemConfig::first();
        return $dfpw->password;
    }

    // TODO: need upgrade in future
    public function setdefaultPassword($newPass)
    {
        $dfpw = SystemConfig::first();
        $dfpw->password = $newPass;
        return $dfpw;
    }
}
