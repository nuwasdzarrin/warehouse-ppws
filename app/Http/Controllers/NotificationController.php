<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * NotificationController
 */
class NotificationController extends Controller
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
        $institution_id = request()->cookie('institution_id');

        $products = Product::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->where('stock','<=','5')->orderByDesc('updated_at')->get();

        return response()->view('notification', [
            'products'=>$products
        ]);
    }
}
