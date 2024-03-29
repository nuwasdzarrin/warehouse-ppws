<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * ProductCategory Model
 */
class ProductCategory extends BaseModel
{
    /** @var string Filter Class */
    protected $filters = 'App\Filters\ProductCategoryFilter';

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
            return $query->where($query->qualifyColumn('institution_id'), $user->institution_id);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

}
