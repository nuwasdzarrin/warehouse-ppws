<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

/**
 * StockReportController
 */
class StockReportController extends Controller
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
    public function index()
    {
        $institution_id = request()->cookie('institution_id');

        $products = Product::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->filter()->paginate()->appends(request()->query());

        return response()->view('stock_report', [
            'products' => $products
        ]);
    }

    public function print()
    {
        $institution_id = request()->cookie('institution_id');

        $products = Product::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->filter()->paginate()->appends(request()->query());

        $pdf = PDF::loadView('prints.stock_report', [ 'products' => $products, 'chartImg' => request()->chartImg ])
            ->setPaper('a3')
            ->setOption('margin-bottom', 10)
            ->setOption('enable-javascript', true)
            ->setOption('javascript-delay', 5000)
            ->setOption('title', "Cetak Laporan Transaksi");
        $pdf->inline("cetak-laporan-tarnsaksi.pdf");
        return $pdf->stream('cetak-laporan-stock.pdf');

//        script for debugging
//        if (request()->exists('dev')) return response()->view('prints.stock_report', [ 'products' => $products ]);
    }
}
