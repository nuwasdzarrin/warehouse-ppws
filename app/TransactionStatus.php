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

    // TODO: Define other default value and relations

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('by_user', function (Builder $query) {
            return $query->byUser();
        });
    }

    /**
     * @param Builder $query
     * @param User|null $user
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function scopeByUser(Builder $query, User $user = null)
    {
        $user = $user ? : auth()->user();
        return $query->when($user instanceof User && $user->hasRole(['staff']), function (Builder $query) use($user) {
            return $query->whereNotIn('name', ['Penyesuaian']);
        });
    }

    public function getTransactionTypeAttribute()
    {
        return ucwords(__('transaction_statuses.'.$this->type));
    }
}
