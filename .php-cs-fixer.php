<?php

$finder = PhpCsFixer\Finder::create()
	->in(__DIR__ . '/src');

return (new PhpCsFixer\Config)
	->setRiskyAllowed(true)
	->setRules([
		'align_multiline_comment' => [
			'comment_type' => 'phpdocs_only'
		],
		'array_indentation' => true,
		'array_syntax' => [
			'syntax' => 'short'
		],
		'binary_operator_spaces' => [
			'default' => 'single_space'
		],
		'blank_line_after_namespace' => true,
		'blank_line_after_opening_tag' => true,
		'blank_line_before_statement' => [
			'statements' => [
				'declare'
			]
		],
		'cast_spaces' => [
			'space' => 'single'
		],
		'concat_space' => [
			'spacing' => 'one'
		],
		'declare_strict_types' => true,
		'elseif' => true,
		'fully_qualified_strict_types' => true,
		'global_namespace_import' => [
			'import_constants' => true,
			'import_functions' => true,
			'import_classes' => null,
		],
		'header_comment' => [
			'comment_type' => 'comment',
			'header' => <<<BODY
 ____                    _    __          
|  _ \    ___     __ _  (_)  / _|  _   _  
| | | |  / _ \   / _` | | | | |_  | | | | 
| |_| | | (_) | | (_| | | | |  _| | |_| | 
|____/   \___/   \__, | |_| |_|    \__, | 
                 |___/             |___/	
				 	
Copyright 2024 ZyloxDeveloper

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), 
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
				 
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
				 
THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

@author ZyloxDeveloper
@link https://github.com/ZyloxDeveloper


BODY,
			'location' => 'after_open'
		],
		'indentation_type' => true,
		'logical_operators' => true,
		'native_constant_invocation' => [
			'scope' => 'namespaced'
		],
		'native_function_invocation' => [
			'scope' => 'namespaced',
			'include' => ['@all'],
		],
		'new_with_braces' => [
			'named_class' => true,
			'anonymous_class' => false,
		],
		'no_closing_tag' => true,
		'no_empty_phpdoc' => true,
		'no_extra_blank_lines' => true,
		'no_superfluous_phpdoc_tags' => [
			'allow_mixed' => true,
		],
		'no_trailing_whitespace' => true,
		'no_trailing_whitespace_in_comment' => true,
		'no_whitespace_in_blank_line' => true,
		'no_unused_imports' => true,
		'ordered_imports' => [
			'imports_order' => [
				'class',
				'function',
				'const',
			],
			'sort_algorithm' => 'alpha'
		],
		'phpdoc_align' => [
			'align' => 'vertical',
			'tags' => [
				'param',
			]
		],
		'phpdoc_line_span' => [
			'property' => 'single',
			'method' => null,
			'const' => null
		],
		'phpdoc_trim' => true,
		'phpdoc_trim_consecutive_blank_line_separation' => true,
		'return_type_declaration' => [
			'space_before' => 'one'
		],
		'single_blank_line_at_eof' => true,
		'single_import_per_statement' => true,
		'strict_param' => true,
		'unary_operator_spaces' => true,
	])
	->setFinder($finder)
	->setIndent("\t")
	->setLineEnding("\n");
