<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;

class ParserTest extends TestCase
{
    public function testJsonParsing(): void
    {
        $filePath = __DIR__ . '/fixtures/json/file1.json';
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

    public function testYamlParsing(): void
    {
        $filePath = __DIR__ . '/fixtures/yaml/file1.yaml';
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
