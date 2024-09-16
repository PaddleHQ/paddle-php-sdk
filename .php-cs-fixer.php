<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->exclude('vendor')
    ->in([getcwd()]);

$config = new Config();

return $config->setRules([
    '@PSR12' => true,
    '@Symfony' => true,
    'trailing_comma_in_multiline' => [
        'after_heredoc' => true,
        'elements' => ['arguments', 'arrays', 'match', 'parameters'],
    ],
    'array_syntax' => ['syntax' => 'short'],
    'yoda_style' => [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ],
    'declare_strict_types' => true,
    'visibility_required' => [
        'elements' => ['property', 'method'],
    ],
    'no_superfluous_phpdoc_tags' => true,
    'php_unit_method_casing' => [
        'case' => 'snake_case',
    ],
    'not_operator_with_successor_space' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    // Disable self_accessor to allow self intersection return types.
    // 'self_accessor' => true,
    'nullable_type_declaration' => ['syntax' => 'union'],
    'ordered_types' => [
        'null_adjustment' => 'always_last',
        'sort_algorithm' => 'none',
    ],
])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
