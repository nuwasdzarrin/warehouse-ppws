<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Institution;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

/**
 * ProductImportExcelController
 */
class ProductImportExcelController extends Controller
{
    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param Product $product
     * @return array
     */
    public static function fields(Request $request = null)
    {
        $timestamp = old('timestamp', now()->timestamp);
        return [
            'import' => [
                'product' => [
                    [ 'field' => 'input', 'type' => 'hidden', 'name' => 'timestamp', 'label' => '', 'value' => $timestamp ],
                    [ 'field' => 'input', 'type' => 'file', 'name' => 'file', 'label' => ucwords('File'),
                        'template' => route('product_import_excel.export', [ 'timestamp' => $timestamp ]),
                        'information' => 'Upload file with format csv,xls, or xlsx',
                        'accept' => 'text/plain, .csv, .xls, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'
                    ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @return array
     */
    public static function rules(Request $request = null)
    {
        return [
            'import' => [
                'file' => 'required|file|mimes:csv,xls,xlsx|max:1024'
            ]
        ];
    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', 'App\Product');

        return response()->view('product_import_excels.create', [
            'fields' => self::fields(request())['import']
        ]);
    }

    /**
     * Export a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Product $product)
    {
        $this->authorize('export', 'App\Product');

        $institution = Institution::byUser(auth()->user())->find(request()->cookie('institution_id')) ? : Institution::byUser(auth()->user())->first();

        return Excel::download(new ProductsExport($institution->name), 'products_'.now()->format('Y-m-d_H.i').'.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function import(Request $request)
    {
        $this->authorize('import', 'App\Product');
        $request->validate(self::rules($request)['import']);

        $institution_id = (request()->cookie('institution_id')) ? : Institution::byUser(auth()->user())->first()->id;

        try {
            Excel::import(new ProductsImport((int) $institution_id), $request->file('file'));
        } catch (ValidationException $exception) {
            return back()->withInput()->with('status', new HtmlString(
                "<div style='margin-bottom: 5px'>{$exception->getMessage()}</div>".
                "<ul>".
                "<li>".implode('</li><li>', $exception->validator->errors()->all())."</li>".
                "</ul>"
            ))->with('status-type', 'danger');
        } catch (\Exception $exception) {
            return back()->withInput()->with('status', $exception->getMessage())->with('status-type', 'danger');
        }

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('products.index');

        return $response->with('status', __('Success'));
    }
}
