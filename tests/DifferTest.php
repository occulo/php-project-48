<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;
use Hexlet\Code\Differ;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $firstPath = __DIR__ . '/fixtures/file1.json';
        $secondPath = __DIR__ . '/fixtures/file2.json';
        $firstFile = ParserFactory::build($firstPath)->parse($firstPath);
        $secondFile = ParserFactory::build($secondPath)->parse($secondPath);
        $differ = new Differ();
        $actual = $differ->genDiff($firstFile, $secondFile);
        $expected = [
            'follow' => [
                'status' => 'removed',
                'value' => false
            ],
            'host' => [
                'status' => 'unchanged',
                'value' => 'hexlet.io'
            ],
            'ports' => [
                'status' => 'changed',
                'value' => [
                    'old' => [80, 443, 8080],
                    'new' => [80, 443]
                ]
            ],
            'proxy' => [
                'status' => 'removed',
                'value' => '123.234.53.22'
            ],
            'settings' => [
                'status' => 'nested',
                'children' => [
                    'features' => [
                        'status' => 'nested',
                        'children' => [
                            'auth' => [
                                'status' => 'unchanged',
                                'value' => true
                            ],
                            'beta' => [
                                'status' => 'removed',
                                'value' => true
                            ],
                            'cache' => [
                                'status' => 'changed',
                                'value' => [
                                    'old' => false,
                                    'new' => true
                                ]
                            ]
                        ]
                    ],
                    'mode' => [
                        'status' => 'changed',
                        'value' => [
                            'old' => 'development',
                            'new' => 'production'
                        ]
                    ],
                    'retry' => [
                        'status' => 'unchanged',
                        'value' => 3
                    ]
                ]
            ],
            'timeout' => [
                'status' => 'changed',
                'value' => [
                    'old' => 50,
                    'new' => 20
                ]
            ],
            'verbose' => [
                'status' => 'added',
                'value' => true
            ]
        ];
        $this->assertEquals($expected, $actual);
    }
}
