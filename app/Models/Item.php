<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\User;
use Helper;

/**
 * @property int $CHARACTER_IDX
 * @property int $ITEM_DBIDX
 * @property int $ITEM_IDX
 * @property int $ITEM_POSITION
 * @property int $ITEM_QPOSITION
 * @property int $ITEM_DURABILITY
 * @property int $ITEM_PYOGUKIDX
 * @property int $ITEM_MUNPAIDX
 * @property int $ITEM_FAMILYIDX
 * @property int $ITEM_SHOPIDX
 * @property int $ITEM_PARAM
 * @property int $ITEM_RAREIDX
 * @property integer $ITEM_SEAL
 * @property string $ITEM_ENDTIME
 * @property int $ITEM_REMAINTIME
 * @property int $PET_IDX
 */
class Item extends Model
{
    use LogsActivity;
    protected $primaryKey = 'ITEM_DBIDX';

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
            ->dontSubmitEmptyLogs()
            ->logOnly(['CHARACTER_IDX', 'ITEM_DBIDX', 'ITEM_IDX', 'ITEM_POSITION', 'ITEM_DURABILITY', 'ITEM_SHOPIDX']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $model = $activity['subject'];
        $name = User::find($model->ITEM_SHOPIDX)->id_loginid;
        $activity->description = "Item has been {$eventName} for user {$name}";
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TB_Item';

    /**
     * @var array
     */
    protected $fillable = ['CHARACTER_IDX', 'ITEM_DBIDX', 'ITEM_IDX', 'ITEM_POSITION', 'ITEM_QPOSITION', 'ITEM_DURABILITY', 'ITEM_PYOGUKIDX', 'ITEM_MUNPAIDX', 'ITEM_FAMILYIDX', 'ITEM_SHOPIDX', 'ITEM_PARAM', 'ITEM_RAREIDX', 'ITEM_SEAL', 'ITEM_ENDTIME', 'ITEM_REMAINTIME', 'PET_IDX'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'gamedb';
    public $timestamps = false;

}
