<?php

namespace App\Http\Controllers;

use App\Transaction;
use mikehaertl\wkhtmlto\Pdf;
use Illuminate\Database\Eloquent\Builder;
//use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

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
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // TODO: Controller logic
        $institution_id = request()->cookie('institution_id');

        $transactions = Transaction::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->filter()->paginate()->appends(request()->query());

        if (request()->exists('pdf')) {
            $render = view('prints.transaction_report', [ 'transactions' => $transactions ])->render();

            $pdf = new Pdf;
            $pdf->addPage($render);
            $pdf->setOptions(['javascript-delay' => 5000]);
            return $pdf->send('Laporan Transaksi '.\Carbon\Carbon::now()->format('d M Y').'.pdf');

//            return PDF::loadView('prints.transaction_report', [ 'transactions' => $transactions ])
//                ->setPaper('a3')
//                ->setOption('margin-bottom', 10)
//                ->setOption('margin-top', 11)
//                ->setOption('enable-javascript', true)
//                ->setOption('javascript-delay', 5000)
//                ->setOption('title', "Cetak Laporan Transaksi")
//                ->inline("cetak-laporan-tarnsaksi.pdf");
        }

//        script for debugging
        if (request()->exists('dev')) return response()->view('prints.transaction_report', [ 'transactions' => $transactions ]);

        return response()->view('transaction_report', [
            'transactions' => $transactions
        ]);
    }
}
