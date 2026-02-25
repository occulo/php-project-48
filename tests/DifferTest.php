<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;
use Hexlet\Code\Differ;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $firstPath = __DIR__ . '/fixtures/json/file1.json';
        $secondPath = __DIR__ . '/fixtures/json/file2.json';
        $firstFile = ParserFactory::build($firstPath)->parse($firstPath);
        $secondFile = ParserFactory::build($secondPath)->parse($secondPath);
        $differ = new Differ();
        $actual = $differ->genDiff($firstFile, $secondFile);
        $expected = [
            'common' => [
                'status' => 'nested',
                'children' => [
                    'setting1' => ['status' => 'unchanged', 'value' => 'Value 1'],
                    'setting2' => ['status' => 'removed', 'value' => 200],
                    'setting3' => [
                        'status' => 'changed',
                        'value' => ['old' => true, 'new' => null],
                    ],
                    'setting6' => [
                        'status' => 'nested',
                        'children' => [
                            'key' => ['status' => 'unchanged', 'value' => 'value'],
                            'doge' => [
                                'status' => 'nested',
                                'children' => [
                                    'wow' => [
                                        'status' => 'changed',
                                        'value' => ['old' => '', 'new' => 'so much'],
                                    ],
                                ],
                            ],
                            'ops' => ['status' => 'added', 'value' => 'vops'],
                        ],
                    ],
                    'follow' => ['status' => 'added', 'value' => false],
                    'setting4' => ['status' => 'added', 'value' => 'blah blah'],
                    'setting5' => [
                        'status' => 'added',
                        'value' => ['key5' => 'value5'],
                    ],
                ],
            ],
            'group1' => [
                'status' => 'nested',
                'children' => [
                    'baz' => [
                        'status' => 'changed',
                        'value' => ['old' => 'bas', 'new' => 'bars'],
                    ],
                    'foo' => ['status' => 'unchanged', 'value' => 'bar'],
                    'nest' => [
                        'status' => 'changed',
                        'value' => ['old' => ['key' => 'value'], 'new' => 'str'],
                    ],
                ],
            ],
            'group2' => [
                'status' => 'removed',
                'value' => ['abc' => 12345, 'deep' => ['id' => 45]],
            ],
            'group3' => [
                'status' => 'added',
                'value' => ['deep' => ['id' => ['number' => 45]], 'fee' => 100500],
            ],
        ];
        $this->assertEquals($expected, $actual);
    }
}
