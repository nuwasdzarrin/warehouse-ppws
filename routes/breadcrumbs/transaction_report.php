<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('transaction_report', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('transaction_report.plural')), route('transaction_report'));
});
