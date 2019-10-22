<?php

$header = <<<HEADER
This file is part of bhittani/kk-star-ratings.

(c) Kamal Khan <shout@bhittani.com>

For the full copyright and license information, please view
the LICENSE file that was distributed with this source code.
HEADER;

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,
    'yoda_style' => false,
    'phpdoc_order' => true,
    'no_useless_else' => true,
    'heredoc_to_nowdoc' => true,
    'no_short_echo_tag' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'single_line_after_imports' => true,
    'combine_consecutive_unsets' => true,
    'header_comment' => compact('header'),
    'array_syntax' => ['syntax' => 'short'],
    'not_operator_with_successor_space' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'ordered_imports' => ['sortAlgorithm' => 'length'],
    'no_extra_consecutive_blank_lines' => [
        'use',
        'extra',
        'break',
        'throw',
        'return',
        'continue',
        'curly_brace_block',
        'square_brace_block',
        'parenthesis_brace_block',
    ],
];

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder($finder);
