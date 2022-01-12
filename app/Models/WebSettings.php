<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class WebSettings extends Model
{
    use LogsActivity;

    protected $connection = 'memberdb';
    protected $table = 'Web_Settings';
    protected $primaryKey = 'data';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = ['data', 'value'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('admin')
            ->setDescriptionForEvent(fn(string $eventName) => "Web configurations have been {$eventName}")
            //->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logOnly(['*']);
    }

}

