<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('notification', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('notification.plural')), route('notification'));
});
