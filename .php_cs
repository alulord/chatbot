<?php
$fileHeaderComment = <<<COMMENT
PHP version 7.1.17
This file is part of ChatBot project.

@author  Peter Simoncic <alulord@gmail.com>
@license GNU AGPLv3

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
COMMENT;
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;
return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => ['header' => $fileHeaderComment, 'separate' => 'both', 'commentType' => 'PHPDoc'],
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'php_unit_strict' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
        'strict_comparison' => true,
        'strict_param' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/.php_cs.cache')
;