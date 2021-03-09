<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => array(
        'enabled' => true,
        'binary'  => env('WKHTMLTOPDF_BINARY', base_path('vendor/bin/wkhtmltopdf-amd64')),
        'timeout' => false,
        'options' => array(
            'print-media-type' => true,
            'page-size' => 'A4',
            'margin-top' => 0,
            'margin-left' => 0,
            'margin-right' => 0
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => env('WKHTMLTOIMAGE_BINARY', base_path('vendor/bin/wkhtmltoimage-amd64')),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

];
