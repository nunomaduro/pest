<?php

declare(strict_types=1);

return [
    'preset' => 'default',
    'exclude' => [
        'phpinsights.php',
        'src/bootstrap.php',
    ],
    'add' => [],
    'remove' => [],
    'config' => [
        \SlevomatCodingStandard\Sniffs\Functions\StaticClosureSniff::class => [
            'exclude' => [
                'src/Execution.php',
            ],
        ],
    ],

];
