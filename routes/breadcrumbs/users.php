<?php

use App\User ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('users.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('users.plural')), route('users.index'));
});
Breadcrumbs::register('users.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push(__('Create'), route('users.create'));
});
Breadcrumbs::register('users.show', function (BreadcrumbsGenerator $breadcrumbs, User $user) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push($user->name, route('users.show', $user->id));
});
Breadcrumbs::register('users.edit', function (BreadcrumbsGenerator $breadcrumbs, User $user) {
    $breadcrumbs->parent('users.show', $user);
    $breadcrumbs->push(__('Edit'));
});
