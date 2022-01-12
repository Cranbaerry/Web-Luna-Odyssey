<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    protected $connection = 'gamedb';
    protected $table = 'TB_GUILD';
    protected $primaryKey = 'GuildIdx';
    public $timestamps = false;

    // LARAVEL 8 BUG WORKAROUND
    // https://stackoverflow.com/questions/32422593/laravel-belongsto-relationship-with-different-databases-not-working
    public function __construct(array $attributes = []) {
        $this->table = env('DB_GAME') . '.dbo.' . $this->table;
        parent::__construct();
    }

    public function masterCharacter()
    {
        $newResource = clone $this;
        return $newResource
            ->setConnection('memberdb')
            ->belongsTo(Character::class, 'MasterIdx', 'CHARACTER_IDX');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'GuildIdx', 'GuildName', 'MasterIdx', 'MasterName', 'GuildLevel', 'SCORE'
    ];
}

