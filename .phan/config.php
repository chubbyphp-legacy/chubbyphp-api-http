<?php

return [
    "target_php_version" => null,
    'directory_list' => [
        'src',
        'vendor/chubbyphp/chubbyphp-deserialization',
        'vendor/chubbyphp/chubbyphp-serialization',
        'vendor/pimple/pimple',
        'vendor/psr/http-message',
    ],
    "exclude_analysis_directory_list" => [
        'vendor/'
    ],
    'plugins' => [
        'AlwaysReturnPlugin',
        'UnreachableCodePlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
    ],
];
