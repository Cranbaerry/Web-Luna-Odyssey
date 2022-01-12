<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $userid
 * @property string $code
 * @property string $date_created
 */
class RedeemClaim extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Web_RedeemClaim';


    /**
     * @var array
     */
    protected $fillable = ['code', 'userid'];

}
