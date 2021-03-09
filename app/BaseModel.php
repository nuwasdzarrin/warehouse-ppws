<?php

namespace App;

use Smartisan\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Atnic\LaravelGenerator\Traits\HasExtendedAttributes;
use Atnic\LaravelGenerator\Traits\ResolveRouteBindingWithFilter;
use Atnic\LaravelGenerator\Traits\SetterGetterExtendedAttribute;

/**
 * BaseModel Model
 */
class BaseModel extends Model
{
    use Filterable, HasExtendedAttributes, ResolveRouteBindingWithFilter, SetterGetterExtendedAttribute;
}
