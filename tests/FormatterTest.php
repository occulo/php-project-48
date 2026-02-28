<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;
use Hexlet\Code\FormatterFactory;
use Hexlet\Code\Differ;

class FormatterTest extends TestCase
{
    private const EXPECTED_OUTPUT = [
        'stylish' => __DIR__ . '/fixtures/expected_stylish.txt',
        'plain' => __DIR__ . '/fixtures/expected_plain.txt',
        'json' => __DIR__ . '/fixtures/expected_json.txt',
    ];

    public static function fileAndFormatProvider(): array
    {
        $files = [
            'json' => [
                __DIR__ . '/fixtures/json/file1.json',
                __DIR__ . '/fixtures/json/file2.json'
            ],
            'yaml' => [
                __DIR__ . '/fixtures/yaml/file1.yaml',
                __DIR__ . '/fixtures/yaml/file2.yaml'
            ],
        ];
        $formats = array_keys(self::EXPECTED_OUTPUT);
        $data = [];
        foreach ($files as $extension => [$firstPath, $secondPath]) {
            foreach ($formats as $format) {
                $data["{$extension}: {$format}"] = [$firstPath, $secondPath, $format];
            }
        }
        return $data;
    }

    private function getDiff($firstPath, $secondPath, $style)
    {
        $firstFile = ParserFactory::build($firstPath)->parse($firstPath);
        $secondFile = ParserFactory::build($secondPath)->parse($secondPath);
        $differ = new Differ();
        $diff = $differ->genDiff($firstFile, $secondFile);
        return FormatterFactory::build($style)->format($diff);
    }

    #[DataProvider('fileAndFormatProvider')]
    public function testFormatting($firstPath, $secondPath, $format): void
    {
        $actual = $this->getDiff($firstPath, $secondPath, $format);
        $expected = self::EXPECTED_OUTPUT[$format];
        $this->assertSame(trim(file_get_contents($expected)), trim($actual));
    }
}
