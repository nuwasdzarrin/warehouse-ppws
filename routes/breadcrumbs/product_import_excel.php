<?php

use App\Product ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('product_import_excel.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push(__('Create'), route('product_import_excel.create'));
});
