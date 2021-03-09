<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function streamResponse(Request $request, $path)
    {
        /** @var \Symfony\Component\HttpFoundation\StreamedResponse $response */
        $response = \Illuminate\Support\Facades\Storage::response($path, null, ['Accept-Range' => 'bytes']);
        if (!$request->hasHeader('range')) return $response;
        /** @var \Illuminate\Filesystem\FilesystemAdapter $adapter */
        $adapter = \Illuminate\Support\Facades\Storage::disk();
        $size = $adapter->size($path);
        $ranges = explode('=', $request->header('range'));
        if (!(isset($ranges[0]) && $ranges[0] == 'bytes' && isset($ranges[1]))) return $response;
        $bytes = explode('-', explode(',', $ranges[1])[0]);
        $bytes[1] = $bytes[1] ?? ($size - 1);
        if (empty($bytes[0]) && $bytes[0] == "") {
            $bytes[0] = $size - $bytes[1];
            $bytes[1] = $size - 1;
        }
        $bytes = array_map(function ($v) { return (integer) $v; }, $bytes);
        if ($bytes[0] <  $bytes[1] && $bytes[1] < $size) {
            $response->setStatusCode(206);
            $response->headers->add([
                'Content-Range' => $ranges[0] . " " . $bytes[0] . "-" . $bytes[1] . "/" . $size,
                'Content-Length' => $bytes[1] - $bytes[0] + 1,
            ]);
            $response->setCallback(function () use ($adapter, $size, $path, $bytes) {
                $stream = $adapter->readStream($path);
                fseek($stream, $bytes[0] ?? 0);
                echo fread($stream, $bytes[1] - $bytes[0] + 1);
                fclose($stream);
            });
        }
        return $response;
    }
}
