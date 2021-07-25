<?php

use App\Product ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('products.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push(__('Create'), route('products.import'));
});
