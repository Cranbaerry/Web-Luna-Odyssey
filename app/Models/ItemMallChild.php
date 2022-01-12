<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $MallItemID
 * @property string $Name
 * @property string $Image
 */
class ItemMallChild extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Web_ItemMallChild';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @var array
     */

    protected $fillable = ['id', 'MallItemID', 'Name', 'Image'];

}
