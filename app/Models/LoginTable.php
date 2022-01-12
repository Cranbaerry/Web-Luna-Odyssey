<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginTable extends Model
{
    protected $connection = 'memberdb';
    protected $table = 'LoginTable';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'userid', 'propid', 'ip', 'Login_date'
    ];
}
