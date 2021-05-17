<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * Institution Model
 */
class Institution extends BaseModel
{
    /** @var string Filter Class */
    protected $filters = 'App\Filters\InstitutionFilter';

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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('global', function (Builder $query) {
            if (empty($query->getQuery()->columns))
                $query->select([
                    '*' => $query->qualifyColumn('*')
                ]);
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
            return $query->whereKey($user->institution_id);
        });
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function product_category()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function filter_ins()
    {
        return false;
    }
}
