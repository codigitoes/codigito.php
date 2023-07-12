<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces'  => [
            'default'   => 'align_single_space_minimal',
            'operators' => [
                '=' => 'align_single_space_minimal',
                '=>' => 'align_single_space_minimal',
            ]
        ],
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
    ])
    ->setFinder($finder);
