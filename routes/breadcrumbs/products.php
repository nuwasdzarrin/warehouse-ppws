<?php

use App\Product ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('products.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('products.plural')), route('products.index'));
});
Breadcrumbs::register('products.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push(__('Create'), route('products.create'));
});
Breadcrumbs::register('products.show', function (BreadcrumbsGenerator $breadcrumbs, Product $product) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push($product->name, route('products.show', $product->id));
});
Breadcrumbs::register('products.edit', function (BreadcrumbsGenerator $breadcrumbs, Product $product) {
    $breadcrumbs->parent('products.show', $product);
    $breadcrumbs->push(__('Edit'));
});
Breadcrumbs::register('products.adjust', function (BreadcrumbsGenerator $breadcrumbs, Product $product) {
    $breadcrumbs->parent('products.show', $product);
    $breadcrumbs->push(__('Adjust'));
});
