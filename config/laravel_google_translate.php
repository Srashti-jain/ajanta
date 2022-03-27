<?php
return [
    'google_translate_api_key'=> 'AIzaSyCE6JtNFtuBR4C6k0UvJyUhB29CrBQKqOI',
    'path' => base_path(),
    'trans_functions' => [
        'trans',
        'trans_choice',
        'Lang::get',
        'Lang::choice',
        'Lang::trans',
        'Lang::transChoice',
        '@lang',
        '@choice',
        '__',
        '\$trans.get',
        '\$t'
    ],
];
