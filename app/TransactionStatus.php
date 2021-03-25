<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * TransactionStatus Model
 */
class TransactionStatus extends BaseModel
{
    /** @var string Filter Class */
    protected $filters = 'App\Filters\TransactionStatusFilter';

    /** @var string $table */
    //protected $table = '';

    /** @var string $primaryKey */
    //protected $primaryKey = '';

    /** @var bool $incrementing */
    //public $incrementing = false;

    /** @var string $keyType */
    //protected $keyType = 'string';

    /** @var bool $timestamps */
    //public $timestamps = false;

    /** @var string $dateFormat */
    //protected $dateFormat = 'U';

    /** @var string CREATED_AT */
    //const CREATED_AT = '';
    /** @var string UPDATED_AT */
    //const UPDATED_AT = '';

    /** @var string $connection */
    //protected $connection = '';

    public function getTransactionTypeAttribute()
    {
        return ucwords(__('transaction_statuses.'.$this->type));
    }
}
