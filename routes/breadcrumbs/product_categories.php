<?php

use App\ProductCategory ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('product_categories.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('product_categories.plural')), route('product_categories.index'));
});
Breadcrumbs::register('product_categories.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('product_categories.index');
    $breadcrumbs->push(__('Create'), route('product_categories.create'));
});
Breadcrumbs::register('product_categories.show', function (BreadcrumbsGenerator $breadcrumbs, ProductCategory $product_category) {
    $breadcrumbs->parent('product_categories.index');
    $breadcrumbs->push($product_category->name, route('product_categories.show', $product_category->id));
});
Breadcrumbs::register('product_categories.edit', function (BreadcrumbsGenerator $breadcrumbs, ProductCategory $product_category) {
    $breadcrumbs->parent('product_categories.show', $product_category);
    $breadcrumbs->push(__('Edit'));
});
