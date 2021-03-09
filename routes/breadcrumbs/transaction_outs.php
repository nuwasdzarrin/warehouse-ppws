<?php

use App\TransactionOut ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('transaction_outs.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('transaction_outs.plural')), route('transaction_outs.index'));
});
Breadcrumbs::register('transaction_outs.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('transaction_outs.index');
    $breadcrumbs->push(__('Create'), route('transaction_outs.create'));
});
Breadcrumbs::register('transaction_outs.show', function (BreadcrumbsGenerator $breadcrumbs, TransactionOut $transaction_out) {
    $breadcrumbs->parent('transaction_outs.index');
    $breadcrumbs->push($transaction_out->id, route('roles.show', $transaction_out->id));
});
Breadcrumbs::register('transaction_outs.edit', function (BreadcrumbsGenerator $breadcrumbs, TransactionOut $transaction_out) {
    $breadcrumbs->parent('transaction_outs.show', $transaction_out);
    $breadcrumbs->push(__('Edit'));
});
