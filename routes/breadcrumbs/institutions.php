<?php

use App\Institution ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('institutions.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('institutions.plural')), route('institutions.index'));
});
Breadcrumbs::register('institutions.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('institutions.index');
    $breadcrumbs->push(__('Create'), route('institutions.create'));
});
Breadcrumbs::register('institutions.show', function (BreadcrumbsGenerator $breadcrumbs, Institution $institution) {
    $breadcrumbs->parent('institutions.index');
    $breadcrumbs->push($institution->name, route('institutions.show', $institution->id));
});
Breadcrumbs::register('institutions.edit', function (BreadcrumbsGenerator $breadcrumbs, Institution $institution) {
    $breadcrumbs->parent('institutions.show', $institution);
    $breadcrumbs->push(__('Edit'));
});
