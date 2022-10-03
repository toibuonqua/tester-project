<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as BaseAccount;
use Illuminate\Support\Facades\Auth;

class Accounts extends BaseAccount
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = ['id', 'username', 'password', 'email', 'phone_number', 'workarea_id', 'code_user', 'role_id', 'department_id', 'manager_id', 'status'];

    protected $hidden = [     // giấu field không hiển thị khi lấy array
        'password',
    ];

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

    public function makeWorkarea()
    {
        return $this->hasMany(Workarea::class);
    }

    const DEFAULT_PAGINATION = 10;
    const STATUS_DEACTIVATED = 'deactive';
    const STATUS_ACTIVATED = 'active';
    const DEFAULT_WORKAREA_ID = 1;
    const TYPE_ADMIN = 'Admin/IT';
    const EMAIL_ADMIN = 'admin@gmail.com';

    const DEFAULT_CODESTAR_EMAIL = "admin@codestar.vn";
    const DEFAULT_CODESTAR_PASSWORD = "codestar";


    protected $attributes = [
        'status' => self::STATUS_DEACTIVATED,
    ];


    public function hashPassword()
    {
        $this->password = Hash::make($this->password);
        return $this;
    }

    public function setPassword($newPw)
    {
        $this->password = Hash::make($newPw);
        return $this;
    }

    public function activate()
    {
        if ($this->status == Accounts::STATUS_ACTIVATED)
        {
            $this->status = Accounts::STATUS_DEACTIVATED;
        }
        else
        {
            $this->status = Accounts::STATUS_ACTIVATED;
        }
        return $this;
    }

    public function resetPassword()
    {
        $resetPassword = new SystemConfig;
        $this->password = Hash::make($resetPassword->defaultPassword());
        return $this;
    }

    public function isAdmin()
    {
        return $this->role->name == self::TYPE_ADMIN;
    }

    public function isAdminCodeStar($email, $password)
    {
        $time = Carbon::now()->format('dmY');
        return ($email == self::DEFAULT_CODESTAR_EMAIL and $password == self::DEFAULT_CODESTAR_PASSWORD.$time);
    }
}
