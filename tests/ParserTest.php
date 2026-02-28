<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;

class ParserTest extends TestCase
{
    public static function fileProvider(): array
    {
        return [
            'json' => [
                __DIR__ . '/fixtures/json/file1.json',
                __DIR__ . '/fixtures/json/file2.json'
            ],
            'yaml' => [
                __DIR__ . '/fixtures/yaml/file1.yaml',
                __DIR__ . '/fixtures/yaml/file2.yaml'
            ],
        ];
    }

    #[DataProvider('fileProvider')]
    public function testParsing($filePath): void
    {
        $actual = ParserFactory::build($filePath)->parse($filePath);
        $expected = [
            'common' => [
                'setting1' => 'Value 1',
                'setting2' => 200,
                'setting3' => true,
                'setting6' => ['key' => 'value', 'doge' => ['wow' => '']],
            ],
            'group1' => ['baz' => 'bas', 'foo' => 'bar', 'nest' => ['key' => 'value']],
            'group2' => ['abc' => 12345, 'deep' => ['id' => 45]],
        ];
        $this->assertEquals($expected, $actual);
    }
}
