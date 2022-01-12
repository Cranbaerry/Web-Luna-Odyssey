<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $connection = 'gamedb';
    protected $table = 'TB_CHARACTER';
    protected $primaryKey = 'CHARACTER_IDX' ;
    protected $maps;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'CHARACTER_IDX', 'USER_IDX', 'CHARACTER_NAME', 'CHARACTER_MAP', 'CHARACTER_EXPOINT',
        'CHARACTER_JOB', 'CHARACTER_JOB1', 'CHARACTER_JOB2', 'CHARACTER_JOB3', 'CHARACTER_JOB4',
        'CHARACTER_JOB5', 'CHARACTER_JOB6', 'CHARACTER_GRADE'
    ];

    public function user()
    {
        $newResource = clone $this;
        return $newResource
            ->setConnection('memberdb')
            ->belongsTo(User::class, 'USER_IDX', 'id_idx');
    }

    function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->maps = new \ArrayObject();
        $this->maps[2] = "Alker Farm";
        $this->maps[3] =  "Nera Farm";
        $this->maps[10] =  "Battle Arena";
        $this->maps[13] =  "Moon Blind Swamp";
        $this->maps[14] =  "Red Orc Outpost";
        $this->maps[15] =  "Moon Blind Forest";
        $this->maps[16] =  "Haunted Mine 1F";
        $this->maps[17] =  "Haunted Mine 2F";
        $this->maps[18] =  "Dunhuang ";
        $this->maps[19] =  "The Gate Of Alker";
        $this->maps[20] =  "Alker Harbor";
        $this->maps[21] =  "Ruins Of Draconian";
        $this->maps[22] =  "Zakandia";
        $this->maps[23] =  "Tarintus";

        $this->maps[25] =  "Mont Blanc Port";
        $this->maps[26] =  "Dryed Gazell Fall";
        $this->maps[27] =  "Zakandia Outpost";
        $this->maps[28] =  "The Dark Portal";
        $this->maps[29] =  "Distoted Crevice";

        $this->maps[31] =  "The Way To The Howling Ravine";
        $this->maps[32] =  "Howling Ravine";
        $this->maps[33] =  "Howling Cave 1F";
        $this->maps[34] =  "Howling Cave 2F";

        $this->maps[41] =  "Ghost Tree Swamp";
        $this->maps[42] =  "Lair Of Kierra";

        $this->maps[51] =  "The Valley Of Fairy";
        $this->maps[52] =  "The Town Of Nera Castle";
        $this->maps[53] =  "The Great Garden";
        $this->maps[54] =  "The Knight Grave";
        $this->maps[55] =  "A Harbor Of Nera";
    }

    public function getMapById($id){
        return $this->maps[$id];
    }

    public function getMapsList() {
        //return $this->maps;
        $maps = new \ArrayObject();
        $maps[19] =  "The Gate Of Alker";
        $maps[20] =  "Alker Harbor";

        return $maps;
    }

    public function getCurrentJob() {
        switch ($this->CHARACTER_JOB) {
            case 1:
                switch ($this->CHARACTER_JOB1) {
                    case 1:
                        return "Fighter";
                    case 2:
                        return "Rogue";
                    case 3:
                        return "Mage";
                    default:
                        return "Undefined Level 1";
                }
            case 2:
                switch ($this->CHARACTER_JOB1) {
                    case 1:
                        switch ($this->CHARACTER_JOB2) {
                            case 1:
                                return "Guard";
                            case 2:
                                return "Warrior";
                        }
                        break;
                    case 2:
                        switch ($this->CHARACTER_JOB2) {
                            case 1:
                                return "Voyager";
                            case 2:
                                return "Ruffian";
                        }
                        break;
                    case 3:
                        switch ($this->CHARACTER_JOB2) {
                            case 1:
                                return "Clerric";
                            case 2:
                                return "Wizzard";
                        }
                        break;
                    default:
                        return "Undefined Level 2";
                }
                break;
            case 3:
                switch ($this->CHARACTER_JOB1) {
                    case 1:
                        switch ($this->CHARACTER_JOB3) {
                            case 1:
                                return "Infantryman";
                            case 2:
                                return "Swordman";
                            case 3:
                                return "Mercenary";
                        }
                        break;
                    case 2:
                        switch ($this->CHARACTER_JOB3) {
                            case 1:
                                return "Archer";
                            case 2:
                                return "Thief";
                            case 3:
                                return "Scout";
                        }
                        break;
                    case 3:
                        switch ($this->CHARACTER_JOB3) {
                            case 1:
                                return "Priest";
                            case 2:
                                return "Sorcerer";
                            case 3:
                                return "Monk";
                        }
                        break;
                    default:
                        return "Undefined Level 3";
                }
                break;
            case 4:
                switch($this->CHARACTER_JOB1) {
                    case 1:
                        switch ($this->CHARACTER_JOB4) {
                            case 1:
                                return "Phalanx";
                            case 2:
                                return "Knight";
                            case 3:
                                return "Gladiator";
                            case 4:
                                return "Rune Knight";
                        }
                        break;
                    case 2:
                        switch ($this->CHARACTER_JOB4) {
                            case 1:
                                return "Ranger";
                            case 2:
                                return "Treasure Hunter";
                            case 3:
                                return "Assassin";
                            case 4:
                                return "Rune Walker";
                        }
                        break;
                    case 3:
                        switch ($this->CHARACTER_JOB4) {
                            case 1:
                                return "Bishop";
                            case 2:
                                return "Warlock";
                            case 3:
                                return "Inquirer";
                            case 4:
                                return "Elemental Master";
                        }
                        break;
                    default:
                        return "Undefined Level 4";
                }
            case 5:
                switch($this->CHARACTER_JOB1) {
                    case 1:
                        switch ($this->CHARACTER_JOB5) {
                            case 1:
                                return "Paladin";
                            case 2:
                                return "Destroyer";
                            case 3:
                                return "Magnus";
                            case 4:
                                return "Sword Master";
                            case 5:
                                return "Panzer";
                        }
                        break;
                    case 2:
                        switch ($this->CHARACTER_JOB5) {
                            case 1:
                                return "Arch Ranger";
                            case 2:
                                return "Sniper";
                            case 3:
                                return "Entrapper";
                            case 4:
                                return "Blade Taker";
                            case 5:
                                return "Temper Master";
                        }
                        break;
                    case 3:
                        switch ($this->CHARACTER_JOB5) {
                            case 1:
                                return "Cardinal";
                            case 2:
                                return "Soul Arbiter";
                            case 3:
                                return "Grand Master";
                            case 4:
                                return "Nercomancer";
                            case 5:
                                return "Rune Master";
                        }
                        break;
                    default:
                        return "Undefined Level 5";
                }
                break;
            default:
                return "Undefined Leve l" . $this->CHARACTER_JOB;
        }
    }

    public function getCurrentMap() {
        return isset($this->maps[$this->CHARACTER_MAP])
            ? $this->maps[$this->CHARACTER_MAP]
            : 'Undefined';
    }
}
