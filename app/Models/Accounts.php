<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = ['id', 'username', 'password', 'email', 'phone_number', 'workarea_id', 'code_user', 'role_id', 'department_id', 'status'];

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

    const DEFAULT_PAGINATION = 3;
    const STATUS_DEACTIVATED = 'deactive';
    const STATUS_ACTIVATED = 'active';
    const DEFAULT_PASSWORD = '123';
    const DEFAULT_WORKAREA_ID = 1;

    protected $attributes = [
        'workarea_id' => self::DEFAULT_WORKAREA_ID,
        'password' => self::DEFAULT_PASSWORD,
        'status' => self::STATUS_DEACTIVATED,
    ];

}
