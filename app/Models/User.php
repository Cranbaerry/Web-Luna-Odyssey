<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Helper;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;
    protected $connection = 'memberdb';
    protected $table = 'chr_log_info';
    protected $primaryKey = 'propid';
    const CREATED_AT = 'id_regdate';
    const UPDATED_AT = 'id_eday';
    protected static $recordEvents = ['updated'];

    public function getActivitylogOptions(): LogOptions
    {
        if (!Helper::isAdmin()) {
            $this->disableLogging();
        }

        return LogOptions::defaults()
            ->useLogName('admin')
            ->setDescriptionForEvent(fn(string $eventName) => "User data has been {$eventName}")
            //->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logOnly(['UserLevel', 'UserPointMall']);
    }

    // LARAVEL 8 BUG WORKAROUND
    // https://stackoverflow.com/questions/32422593/laravel-belongsto-relationship-with-different-databases-not-working
    public function __construct(array $attributes = []) {


        $this->table = env('DB_MEMBER') . '.dbo.' . $this->table;
        parent::__construct($attributes);

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_idx', 'propid', 'code', 'id_loginid', 'id_email', 'id_passwd', 'UserLevel', 'UserPointMall', 'pin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id_passwd', 'remember_token',
    ];

    /**
     * Define scope forUser
     *
     * @param Eloquent $query query builder
     * @param User     $user  limit
     *
     * @return void
     */
    public function scopeForUser($query, $id)
    {
        return $query->where('id_idx', $id);
    }

    public function getEmailAttribute()
    {
        return $this->id_email;
    }

    public function getEmailForPasswordReset()
    {
        return $this->id_email;
    }

    public function setEmailAttribute($value) {
        $this->attributes['id_email'] = $value;
    }

    public function getAuthPassword() {
        return Hash::make($this->id_passwd);
    }

    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->id_email;
        }
    }

    public function getAccessLevel() {
        switcH ($this->UserLevel) {
            case 1:
                return 'God';
            case 2:
                return 'Developer';
            case 3:
                return 'Programmer';
            case 4:
                return 'Game Master';
            case 5:
                return 'Moderator';
            case 6:
                return 'Player';
            case 7:
                return 'BANNED';
        }
    }
}
