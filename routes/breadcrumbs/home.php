<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('home', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('home.plural')), route('home'));
});
