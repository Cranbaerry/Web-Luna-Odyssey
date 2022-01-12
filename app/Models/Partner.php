<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Helper;

class Partner extends Model
{
    use LogsActivity;

    protected $connection = 'memberdb';
    protected $table = 'Web_Partners';
    protected $primaryKey = 'code';
    const CREATED_AT = 'date_created';
    const UPDATED_AT = null;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'userid', 'code', 'virtual_money', 'date_created'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        if (!Helper::isAdmin()) {
            $this->disableLogging();
        }

        return LogOptions::defaults()
            ->useLogName('admin')
            ->setDescriptionForEvent(fn(string $eventName) => "Affiliated Partner has been {$eventName}")
            //->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logOnly(['*']);
    }
}
