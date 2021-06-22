<?php

namespace App\Http\Controllers;

use App\Institution;
use App\Transaction;
use Illuminate\Http\RedirectResponse;
//use mikehaertl\wkhtmlto\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

/**
 * TransactionReportController
 */
class TransactionReportController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Invoke single action controller.
     *
     * @return \Illuminate\Http\Response|RedirectResponse
     */
    public function index()
    {
        $institution_id = request()->cookie('institution_id');

        $transactions = Transaction::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->filter()->paginate()->appends(request()->query());

        return response()->view('transaction_report', [
            'transactions' => $transactions
        ]);
    }

    public function print()
    {
        $institution_id = request()->cookie('institution_id');

        $institution = Institution::query()->find($institution_id);
        $transactions = Transaction::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->filter()->paginate()->appends(request()->query());


//        script for debugging
        if (request()->exists('dev'))
            return response()->view('prints.transaction_report', [
                'transactions' => $transactions,
                'chartImg' => request()->chartImg,
                'institution' => $institution
            ]);

        return PDF::loadView('prints.transaction_report', [
            'transactions' => $transactions,
            'chartImg' => request()->chartImg,
            'institution' => $institution ])
            ->setPaper('a3')
            ->setOption('margin-bottom', 10)
            ->setOption('margin-top', 11)
            ->setOption('enable-javascript', true)
            ->setOption('javascript-delay', 5000)
            ->setOption('title', "Cetak Laporan Transaksi")
            ->inline("cetak-laporan-transaksi.pdf");
    }
}
