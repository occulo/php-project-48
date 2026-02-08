<?php

namespace Hexlet\Code;

class Differ
{
    public function genDiff(array $firstFile, array $secondFile): array
    {
        $keys = array_unique(array_merge(array_keys($firstFile), array_keys($secondFile)));
        $diff = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $firstFile) && !array_key_exists($key, $secondFile)) {
                $diff[$key] = ['status' => 'removed', 'value' => $firstFile[$key]];
            } elseif (array_key_exists($key, $secondFile) && !array_key_exists($key, $firstFile)) {
                $diff[$key] = ['status' => 'added', 'value' => $secondFile[$key]];
            } elseif (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile)) {
                if ($firstFile[$key] === $secondFile[$key]) {
                    $diff[$key] = ['status' => 'unchanged', 'value' => $firstFile[$key]];
                } elseif(is_array($firstFile[$key]) && is_array($secondFile[$key])) {
                    $diff[$key] = ['status' => 'nested', 'children' => $this->gendiff($firstFile[$key], $secondFile[$key])];
                } else {
                    $diff[$key] = ['status' => 'changed', 'value' => ['old' => $firstFile[$key], 'new' => $secondFile[$key]]];
                }
            }
            
        }
        return $diff;
    }
}
