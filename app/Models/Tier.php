<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\TierReward;
use Helper;

class Tier extends Model
{
    use LogsActivity;
    protected $primaryKey = 'id';

    protected static $recordEvents = ['created', 'updated'];
    public function getActivitylogOptions(): LogOptions
    {
        if (!Helper::isAdmin()) {
            $this->disableLogging();
        }

        return LogOptions::defaults()
            ->useLogName('admin')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Tier list has been {$eventName}";
            })->logOnly(['*']);
            //->logOnlyDirty()
            //->dontSubmitEmptyLogs();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Web_Tiers';

    /**
     * @var array
     */
    protected $fillable = ['id', 'goal', 'active'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'memberdb';
    public $timestamps = false;

    public function rewards()
    {
        return $this->hasMany(TierReward::class, 'tierId', 'id');
    }
}
