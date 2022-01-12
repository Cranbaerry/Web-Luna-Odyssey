<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $transactionid
 * @property int $userid
 * @property int $itemid
 * @property int $quantity
 * @property int $price
 * @property int $total
 * @property string $date_purchased
 */
class ItemLog extends Model
{
    const CREATED_AT = 'date_purchased';
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Web_ItemMallLog';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'transactionid';

    /**
     * @var array
     */
    protected $fillable = ['userid', 'itemid', 'name', 'quantity', 'price', 'total', 'date_purchased'];

}
