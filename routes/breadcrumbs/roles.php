<?php

use App\Role;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('roles.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('roles.plural')), route('roles.index'));
});
Breadcrumbs::register('roles.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push(__('Create'), route('roles.create'));
});
Breadcrumbs::register('roles.show', function (BreadcrumbsGenerator $breadcrumbs, Role $role) {
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push($role->name, route('roles.show', $role->id));
});
Breadcrumbs::register('roles.edit', function (BreadcrumbsGenerator $breadcrumbs, Role $role) {
    $breadcrumbs->parent('roles.show', $role);
    $breadcrumbs->push(__('Edit'));
});
