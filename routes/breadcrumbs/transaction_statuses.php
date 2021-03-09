<?php

use App\TransactionStatus;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('transaction_statuses.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('transaction_statuses.plural')), route('transaction_statuses.index'));
});
Breadcrumbs::register('transaction_statuses.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('transaction_statuses.index');
    $breadcrumbs->push(__('Create'), route('transaction_statuses.create'));
});
Breadcrumbs::register('transaction_statuses.show', function (BreadcrumbsGenerator $breadcrumbs, TransactionStatus $transaction_status) {
    $breadcrumbs->parent('transaction_statuses.index');
    $breadcrumbs->push($transaction_status->name, route('transaction_statuses.show', $transaction_status->id));
});
Breadcrumbs::register('transaction_statuses.edit', function (BreadcrumbsGenerator $breadcrumbs, TransactionStatus $transaction_status) {
    $breadcrumbs->parent('transaction_statuses.show', $transaction_status);
    $breadcrumbs->push(__('Edit'));
});
