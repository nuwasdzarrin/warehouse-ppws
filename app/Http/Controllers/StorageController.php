<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * StorageController
 */
class StorageController extends Controller
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
     * @param Request $request
     * @param string $path
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(Request $request, $path)
    {
        try {
            return $this->streamResponse($request, $path);
        } catch (FileNotFoundException $exception) {
            throw new HttpException(404, $exception->getMessage(), $exception);
        }
    }
}
