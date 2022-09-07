<?php

namespace App\Models;

use App\Models\ModelTrait\CommonScopeTrait;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class Account extends Authenticatable
{
    use CommonScopeTrait;

    protected $table = 'account';

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     *
     * @var array
     */
    protected $fillable = [     // filter field trước khi lưu vào DB.
        'username',
        'email',
        'password',
        // 'remember_token',
        // 'access_token',
        // 'reset_token',
        'status',
        'type',
        'today_exam_time_minute',
        'expired_at',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [     // giấu field không hiển thị khi lấy array
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'access_token_created_at' => 'datetime',
        'reset_token_created_at' => 'datetime'
    ];

    const DEFAULT_PASSWORD = '123456789';

    const STATUS_DEACTIVATED = 'deactive';
    const STATUS_ACTIVATED = 'active';
    const STATUS_PENDING = 'pending';   // Status for waiting admin to active manually

    const TYPE_USER = 'user';
    const TYPE_ADMIN = 'admin';
    const TYPE_CLASS_ASSISTANT = 'class_assistant';

    const EXPIRED_IN = 20;
    const EXPIRED_IN_MONTH = 6;

    const EXPIRE_UNIT_MINUTE = 'minute';
    const EXPIRE_UNIT_HOUR = 'hour';
    const EXPIRE_UNIT_DAY = 'day';
    const EXPIRE_UNIT_WEEK = 'week';
    const EXPIRE_UNIT_MONTH = 'month';

    const ALLOWED_EXAM_TIME_MINUTE = 300;
    const ALLOWED_EXAM_CREATE = 5;
    const USER_JWT_TOKEN_TTL_IN_HOUR = 5;
    const ASSISTANT_JWT_TOKEN_TTL_IN_DAY = 7;

    const ACCESS_TOKEN_EXPIRED_TIME_IN_DAY = 7;


    protected $attributes = [
        'status' => self::STATUS_PENDING,
        'type' => self::TYPE_USER,
    ];

    /**
     *
     */
    public function resetExamCreateLimit()
    {
        $this->today_exam_created = 0;
    }

    /**
     * Turn the password into a hashed password.
     */
    public function hashPassword()
    {
        $hashedPassword = Hash::make($this->password);
        $this->password = $hashedPassword;
    }

    /**
     * Check if the inputed password is correct.
     *
     * @param string input password
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    /**
     * Update user's password
     *
     * @param $newPassword string contains value of new password to be updated
     * @return void
     */
    public function updatePassword($newPassword)
    {
        $this->password = $newPassword;
        $this->hashPassword();
        $this->save();
    }



    /**
     * Generate key in `access_token` field.
     * This token can be verified using verifyAccessToken()
     *
     * @return string generatedKey Using this key in verifyAccessToken to check if the key is correct
     */
    public function generateAccessToken()
    {
        $generatedKey = Str::random(40);
        $this->access_token = Hash::make($generatedKey);
        $this->access_token_created_at = now();
        $this->access_token_expired_at = now()->addDays(self::ACCESS_TOKEN_EXPIRED_TIME_IN_DAY);
        return $generatedKey;
    }

    /**
     * Verify key has been generated from generateAccessToken
     *
     * @param string key to be verified
     */
    public function verifyAccessToken($key)
    {
        return Hash::check($key, $this->access_token) && now()->lessThan($this->access_token_expired_at);
    }

    /**
     * Check if user has exceeded allowed amount of time for doing exams
     *
     */
    public function isExceedAllowedExamTime()
    {
        $limitUserConfigs = SystemConfiguration::getLimitUserConfigs();

        $timeInSecond = [
            'minute' => 1,
            'hour' => 60,
            'day' => 60 * 24
        ];

        $limitUnit = $limitUserConfigs[SystemConfiguration::UNIT];
        $limitExamTime = $limitUserConfigs[SystemConfiguration::DO_EXAM_TIME];

        $allowedTime = $timeInSecond[$limitUnit] * $limitExamTime;

        // If the day is passed -> reset timeout and return false
        if ($this->updated_at->format('dmy') != Carbon::now()->format('dmy')) {
            $this->today_exam_time_minute = 0;
            $this->save();
            return false;
        }

        return $this->today_exam_time_minute >= $allowedTime;
    }

    /**
     * Update user do exam time of the day
     *
     * @param float $newDoTime new amount of do exam time to be added
     */
    public function updateTodayExamTimeMinute($newDoTime)
    {
        $currentExamTimeMinute = $this->today_exam_time_minute;
        $this->today_exam_time_minute = $currentExamTimeMinute + $newDoTime;
        $this->save();
    }

    /**
     * Check if user has an active session
     */
    public function hasActiveSession()
    {
        return $this->current_session_id != null;
    }

    /**
     * Check if user has an active session with given session id and jwt token
     * @param String $sessionId id of the session to check for
     * @param String $jwtToken
     */
    public function hasCurrentActiveSession($sessionId, $jwtToken)
    {
        if ($this->current_session_id != $sessionId) {
            return false;
        }
        return $this->hasJwtToken($jwtToken) && !$this->isTokenExpired();
    }

    /**
     * check if user is already login in another device
     * @param $sessionId
     * @param $jwtToken
     */
    public function isAlreadyLogin($sessionId, $jwtToken)
    {
        return $this->hasActiveSession() && !$this->hasCurrentActiveSession($sessionId, $jwtToken);
    }

    /**
     * Set current session id for the user
     */
    public function setSessionId($sessionId)
    {
        $this->current_session_id = $sessionId;
    }

    /**
     * Set current jwt token and expire time for the user
     *
     * @param String $token
     * @param DateTime $expiredAt
     */
    public function setJwtToken($token, $expiredAt = null)
    {
        $hashedToken = Hash::make($token);
        $this->jwt_token = $hashedToken;
        $this->jwt_token_expired_at = $expiredAt;
    }

    /**
     * Check if user has a given jwt token currently stored in database
     * @param $token
     */
    public function hasJwtToken($token)
    {
        return Hash::check($token, $this->jwt_token);
    }

    /**
     * Check if current jwt token is expired
     */
    public function isTokenExpired()
    {
        if (!$this->jwt_token) {
            return true;
        }

        $now = Carbon::now();
        $tokenExpiredAt = Carbon::parse($this->jwt_token_expired_at);
        return $tokenExpiredAt->lt($now);
    }


    /**
     * Check if user has exceeded number of allowed attempts for an exam
     *
     * @param Exam $exam exam to be checked for number of attempts
     */
    public function isExceedNumOfAttempts(Exam $exam)
    {
        $numAttempts = ExamResult::notDeleted()->where([
            'account_id' => $this->id,
            'exam_id' => $exam->id
        ])->count();

        return $numAttempts >= $exam->num_attempts;
    }

    /**
     * Check if user status is pending
     */
    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isAssistant()
    {
        return $this->type === self::TYPE_CLASS_ASSISTANT;
    }


    // ## SCOPE FUNCTION

    /**
     * Get all account with type is user
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUser(Builder $query)
    {
        return $query->where("type", self::TYPE_USER);
    }

    public function scopeAssistant(Builder $query)
    {
        return $query->where('type', self::TYPE_CLASS_ASSISTANT);
    }

    public function scopeWithFilter($query, $filters)
    {
        [
            'username' => $username,
            'email' => $email,
            'status' => $status,
            'from' => $from,
            'to' => $to,
            'type' => $type,
            'class_id' => $classId, // can be a list of class id
            'except_class' => $exceptClass,
            'name_or_email' => $nameOrEmail
        ] = $this->addDefault($filters);

        if ($status) {
            $query = $query->whereIn('status', $status);
        }

        if ($type) {
            $query = $query->where('type', $type);
        }

        if ($classId) {
            if (!is_array($classId)) {
                $classId = array($classId);
            }

            $query = $type == self::TYPE_USER ?
                $query->whereHas('registeredClasses', fn ($q) => $q->whereIn('class.id', $classId))
                : $query->whereHas('managedClasses', fn ($q) => $q->whereIn('class.id', $classId));
        }

        if ($exceptClass) {
            $query = $query->exceptClass($exceptClass);
        }

        if ($nameOrEmail) {
            $query = $query->whereLike(['username', 'email'], $nameOrEmail);
        }

        if ($username) {
            $query = $query->whereLike('username', $username);
        }
        if ($email) {
            $query = $query->whereLike('email', $email);
        }
        if ($from) {
            $query = $query->whereDate('created_at', ">=", $from);
        }
        if ($to) {
            $query = $query->whereDate('created_at', "<=", $to);
        }

        return $query;
    }

    public function scopeExceptClass($query, $classId)
    {
        return $query->whereDoesntHave('registeredClasses', fn ($q) => $q->where('class.id', '=', $classId));
    }


    // ## COMPACT SERVICE
    // NOTE: These static functions work as a service, but written in static methods
    // for simplifying. If these methods become complex, please consider decoupling them
    // using service.

    /**
     * Update multiple status in account
     * NOTE: Instead of update status for each Account, update status for an Account list
     * -> reduce query time
     *
     * @param array $statusIdMap contain multiple key-value as id => status
     * @return bool update successful or failed
     */
    public static function updateStatus($idStatusMap)
    {
        $statusIdMap = [];

        foreach ($idStatusMap as $id => $status) {
            if (array_key_exists("$status", $statusIdMap)) {
                $statusIdMap[$status][] = $id;
            } else {
                $statusIdMap[$status] = [$id];
            }
        }

        try {
            foreach ($statusIdMap as $status => $idList) {
                DB::table("account")
                    ->whereIn("type", [self::TYPE_USER, self::TYPE_CLASS_ASSISTANT])    // Admin can change user and class assistant type
                    ->whereIn("id", $idList)
                    ->update(["status" => $status]);
            }
        } catch (Throwable $th) {
            return false;
        }

        return true;
    }

    /**
     * Create student accounts (1 or many)
     *
     * @param array usernameList list of usernames to be created
     * @param  array defaultValues list of default values to be initialized for new accounts
     * @throws Exception
     */
    public static function createStudents($usernameList, $defaultValues)
    {
        $now = Carbon::now();
        $class = Classroom::find($defaultValues['class_id']);

        $hashedPassword = Hash::make($defaultValues['password'] ?? self::DEFAULT_PASSWORD);

        $insertData = array_map(fn ($username) => [
            'username' => $username,
            'password' => $hashedPassword,
            'status' => Account::STATUS_ACTIVATED,
            'email' => $username, // students will be created by email
            'created_at' => $now,
            'updated_at' => $now,
            'expired_at' => $defaultValues['expired_at'],
        ], $usernameList);

        Account::upsert($insertData, ['username'], ['email']);

        $newAccounts = Account::whereIn('username', $usernameList)->orWhere('email', $usernameList)
            ->get();

        foreach ($newAccounts as $account) {
            $class->students()->syncWithoutDetaching([$account->id =>  ["expired_at" => $defaultValues['expired_at']]]);
        }
        $class->save();
    }

    /**
     * Create a new account for class assistant
     *
     * @param array $data contains account information
     * @return Account key for account verification through email
     */
    public static function createAsistant($data)
    {
        $account = new Account($data);
        $account->hashPassword();
        $account->generateAccessToken();

        return $account;
    }

    private function addDefault($filter)
    {
        $defaultParams = [
            'username' => null,
            'email' => null,
            'status' => null,
            'from' => null,
            'to' => null,
            'type' => null,
            'class_id' => null,
            'except_class' => null,
            'name_or_email' => null,
        ];

        return $filter + $defaultParams;
    }

    // Linking methods

    public function getAllCourseAttribute()
    {
        return $this->courses->merge(collect($this->accessClasses->map(function ($class) {
            return $class->course;
        })->all()));
    }

    public function registeredClasses()
    {
        return $this->belongsToMany(Classroom::class, 'class_student', 'account_id', 'class_id')
            ->withPivot('expired_at');
    }

    public function accessClasses()
    {
        return $this->belongsToMany(Classroom::class, 'class_student', 'account_id', 'class_id')
            ->withPivot('expired_at')
            ->wherePivot('expired_at', '>', now())
            ->with('course');
    }


    public function managedClasses()
    {
        return $this->belongsToMany(Classroom::class, 'class_assistant', 'account_id', 'class_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'account_course', 'account_id', 'course_id')
            ->withPivot('expired_at')->wherePivot('expired_at', '>', now());
    }

    public function managingCourses()
    {
        return $this->hasMany(Course::class, 'admin_id');
    }

    public function registeredCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function didCategories()
    {
        return $this->hasMany(ExamCategory::class)->groupBy('category_id')->join('category', 'account_exam_category.category_id', '=', 'category.id');
    }

    public function didExams()
    {
        return $this->hasMany(ExamCategory::class)->groupBy('exam_id')->join('exam', 'account_exam_category.exam_id', '=', 'exam.id');
    }
}
