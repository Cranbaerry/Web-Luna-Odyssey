<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Tier;
use Helper;

class TierReward extends Model
{
    use LogsActivity;
    protected $primaryKey = 'id';

    protected static $recordEvents = ['created'];
    public function getActivitylogOptions(): LogOptions
    {
        if (!Helper::isAdmin()) {
            $this->disableLogging();
        }

        return LogOptions::defaults()
            ->useLogName('admin')
            //->setDescriptionForEvent(fn(string $eventName) => "Item has been {$eventName}")
            //->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $model = $activity['subject'];
        $activity->description = "Tier Reward {$model->id} has been {$eventName} for Tier ID {$model->tierId}";
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Web_Tiers_Rewards';

    /**
     * @var array
     */
    protected $fillable = ['id', 'name', 'tierId', 'itemId', 'quantity', 'image_link'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'memberdb';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Tier::class, 'id', 'tierId');
    }

}
