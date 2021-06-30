<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

/**
 * Product Model
 */
class Product extends BaseModel
{
    /** @var string Filter Class */
    protected $filters = 'App\Filters\ProductFilter';

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

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function transactions()
    {
        return$this->hasMany(Transaction::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('global', function (Builder $query) {
            if (empty($query->getQuery()->columns))
                $query->select([
                    '*' => $query->qualifyColumn('*')
                ]);
        });

        self::deleting(function($product) {
            $product->transactions()->each(function($transaction) {
                $transaction->delete();
            });
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

    public function getAbbreviationNameAttribute()
    {
        $name_array = explode(" ", $this->name);
        $abb = array_map(function ($name) {
            return str_split($name)[0];
        }, $name_array);
        array_shift($abb);
        return $name_array[0].' '.implode('', $abb);
    }

    public function getPictureHtmlAttribute()
    {
        return $this->picture? new HtmlString("<img src='/storage/$this->picture' alt='transaction-picture' style='width: 200px; height: auto;'>"): '';
    }
}
