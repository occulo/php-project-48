<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private const FIXTURES_DIR = __DIR__ . '/fixtures';

    private const FILES = [
        'json' => [
            self::FIXTURES_DIR . '/json/file1.json',
            self::FIXTURES_DIR . '/json/file2.json'
        ],
        'yaml' => [
            self::FIXTURES_DIR . '/yaml/file1.yaml',
            self::FIXTURES_DIR . '/yaml/file2.yaml'
        ],
    ];

    private const EXPECTED_OUTPUT = [
        'stylish' => self::FIXTURES_DIR . '/expected_stylish.txt',
        'plain' => self::FIXTURES_DIR . '/expected_plain.txt',
        'json' => self::FIXTURES_DIR . '/expected_json.txt',
    ];

    public static function fileAndFormatProvider(): array
    {
        $formats = array_keys(self::EXPECTED_OUTPUT);
        $data = [];
        foreach (self::FILES as $extension => [$firstFile, $secondFile]) {
            $data["{$extension}: default"] = [$firstFile, $secondFile];
            foreach ($formats as $format) {
                $data["{$extension}: {$format}"] = [$firstFile, $secondFile, $format];
            }
        }
        return $data;
    }

    #[DataProvider('fileAndFormatProvider')]
    public function testGenDiff(string $firstPath, string $secondPath, string $format = 'stylish'): void
    {
        $actual = genDiff($firstPath, $secondPath, $format);
        $expected = self::EXPECTED_OUTPUT[$format];
        $this->assertStringEqualsFile($expected, $actual);
    }
}
