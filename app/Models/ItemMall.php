<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use Helper;

/**
 * @property int $item_id
 * @property string $description
 * @property string $effects
 * @property string $img
 * @property int $category
 * @property int $price
 * @property int $min_quantity
 * @property int $max_quantity
 * @property int $featured_label
 */
class ItemMall extends Model
{
    use LogsActivity;

    /**;
     * The table associated with the model.
     *
     * @var string
     */

    protected $connection = 'memberdb';
    protected $primaryKey = 'item_id';
    protected $table = 'Web_ItemMall';
    public $timestamps = false;
    public $incrementing = false;

    public function getActivitylogOptions(): LogOptions
    {
        if (!Helper::isAdmin()) {
            $this->disableLogging();
        }

        return LogOptions::defaults()
            ->useLogName('admin')
            ->setDescriptionForEvent(fn(string $eventName) => "Item Mall has been {$eventName}")
            //->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logOnly(['*']);;
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
//        $model = $activity['subject'];
//        $name = User::find($model->ITEM_SHOPIDX)->id_loginid;
//        $activity->description = "Item has been {$eventName} for user {$name}";
    }

    /**
     * @var array
     */
    protected $fillable = ['item_id', 'name', 'description', 'effects', 'img',
        'category', 'price', 'min_quantity',
        'max_quantity', 'featured_label'];

    public function getCategory(){
        switch ($this->category){
            case 1:
                return 'Equipment';
            case 2:
                return 'Costume';
            case 3:
                return 'Accessories';
            case 4:
                return 'Consumables';
            case 5:
                return 'Back Gears';
            case 6:
                return 'Styles';
        }
    }

    public function getFeaturedLabel(){
        switch ($this->featured_label){
            case 0:
                return 'None';
            case 1:
                return 'New';
            case 2:
                return 'Hot';
        }
    }
}
