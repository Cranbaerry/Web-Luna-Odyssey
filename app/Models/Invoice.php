<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $connection = 'memberdb';
    protected $table = 'Web_Invoices';
    protected $primaryKey = 'transaction_id';
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';

    // LARAVEL 8 BUG WORKAROUND
    // https://stackoverflow.com/questions/32422593/laravel-belongsto-relationship-with-different-databases-not-working
    public function __construct(array $attributes = []) {
        $this->table = env('DB_MEMBER') . '.dbo.' . $this->table;
        parent::__construct();
    }

    public function user()
    {
        $newResource = clone $this;
        return $newResource
            ->setConnection('memberdb')
            ->belongsTo(User::class, 'user_id', 'id_idx');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'transaction_id', 'user_id', 'price', 'method', 'reference', 'payment_url', 'status_code',
        'package', 'cash_points', 'referral_code', 'bonus_points', 'date_created', 'date_updated'
    ];

    public function getPaymentMethod() {
        switch ($this->method) {
            case 'VC':
                return 'Credit Card (Visa / Master)';
            case 'BK':
                return 'BCA KlikPay';
            case 'BC':
                return 'BCA Virtual Account';
            case 'M1':
                return 'Mandiri Virtual Account (Deprecated)';
            case 'M2':
                return 'Mandiri Virtual Account';
            case 'BT':
                return 'Permata Bank Virtual Account';
            case 'A1':
                return 'ATM Bersama';
            case 'B1':
                return 'CIMB Niaga Virtual Account';
            case 'I1':
                return 'BNI Virtual Account';
            case 'VA':
                return 'Maybank Virtual Account';
            case 'FT':
                return 'Ritel';
            case 'OV':
                return 'OVO (Support Void)';
            case 'DN':
                return 'Indodana Paylater';
            case 'SP':
                return 'Shopee Pay';
            case 'SA':
                return 'Shopee Pay Apps (Support Void)';
            case 'AG':
                return 'Bank Artha Graha';
            case 'S1':
                return 'Bank Sahabat Sampoerna';
            case 'LA':
                return 'LinkAja Apps (Percentage Fee)';
            case 'LF':
                return 'LinkAja Apps (Fixed Fee)';
            case 'LQ':
                return 'LinkAja QRIS';
            case 'DA':
                return 'DANA';
            case 'IR':
                return 'Indomaret';
            case 'VM':
                return 'Virtual Money';
            case 'Manual_BCA':
                return 'Manual BCA Transfer';
            default:
                return $this->method;
        }

    }
}

