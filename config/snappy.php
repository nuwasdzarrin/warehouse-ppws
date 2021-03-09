<?php

return array(


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


);
