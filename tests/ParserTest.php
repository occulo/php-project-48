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
        $expected = require __DIR__ . '/fixtures/expected_parser.php';
        $this->assertEquals($expected, $actual);
    }
}
