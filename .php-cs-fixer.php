<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$header = <<<'HEADER'
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
    'new_with_braces' => false,
    'heredoc_to_nowdoc' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'single_line_after_imports' => true,
    'combine_consecutive_unsets' => true,
    'header_comment' => compact('header'),
    'phpdoc_align' => ['align' => 'left'],
    'array_syntax' => ['syntax' => 'short'],
    'not_operator_with_successor_space' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
];

$finder = (new Finder)->in(__DIR__ . '/src');

return (new Config)
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules($rules);
