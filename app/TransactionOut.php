<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

/**
 * TransactionOut Model
 */
class TransactionOut extends BaseModel
{
    /** @var string Filter Class */
    protected $filters = 'App\Filters\TransactionOutFilter';

    /** @var string $table */
    protected $table = 'transactions';

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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('by_type', function (Builder $query) {
            return $query->byType();
        });

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
        return $query->when($user instanceof User && $user->hasRole(['admin','staff']), function (Builder $query) use($user) {
            return $query->where($query->qualifyColumn('institution_id'), $user->institution_id);
        });
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function scopeByType(Builder $query)
    {
        return $query->where((new TransactionOut)->qualifyColumn('in_out'), 'out');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction_status()
    {
        return $this->belongsTo(TransactionStatus::class);
    }

    public function getCreatedAtForHumanAttribute()
    {
        return date('d M Y H:i', strtotime($this->created_at));
    }

    public function getPictureHtmlAttribute()
    {
        return $this->picture? new HtmlString("<img src='/storage/$this->picture' alt='transaction-picture' style='width: 200px; height: auto;'>"): '';
    }
}
