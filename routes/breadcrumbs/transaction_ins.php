<?php

use App\TransactionIn ;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('transaction_ins.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push(ucwords(__('transactions.plural')), route('transaction_ins.index'));
});
Breadcrumbs::register('transaction_ins.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('transaction_ins.index');
    $breadcrumbs->push(__('Create'), route('transaction_ins.create'));
});
Breadcrumbs::register('transaction_ins.show', function (BreadcrumbsGenerator $breadcrumbs, TransactionIn $transaction_in) {
    $breadcrumbs->parent('transaction_ins.index');
    $breadcrumbs->push($transaction_in->id, route('roles.show', $transaction_in->id));
});
Breadcrumbs::register('transaction_ins.edit', function (BreadcrumbsGenerator $breadcrumbs, TransactionIn $transaction_in) {
    $breadcrumbs->parent('transaction_ins.show', $transaction_in);
    $breadcrumbs->push(__('Edit'));
});
