# Gendiff
[![Packagist Version](https://img.shields.io/packagist/v/occulo/gendiff)](https://packagist.org/packages/occulo/gendiff) [![PHP CI](https://github.com/occulo/gendiff/actions/workflows/ci.yml/badge.svg)](https://github.com/occulo/gendiff/actions/workflows/ci.yml) [![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=occulo_gendiff&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=occulo_gendiff)

## Description
Gendiff is a CLI tool and library for generating differences between two configuration files. Supports multiple output formats: stylish, plain, and JSON.

## Prerequisites
* Linux, MacOS, WSL
* PHP >=8.3
* Composer >=2.0
* Git
* Make

## Installation
### Composer (recommended)
If you use Composer, you can install the package locally with the following command:
```bash
composer require occulo/gendiff
```
Or globally:
```bash
composer global require occulo/gendiff
```

### Source
If you wish to install from source, run:
```bash
git clone https://github.com/occulo/gendiff.git
cd gendiff
make install
```
This will clone the repository to your machine and install all required Composer dependencies.

## Supported Formats
Gendiff can compare configuration files in the following formats:
* JSON (`.json`)
* YAML (`.yaml`, `.yml`)

## Usage
```bash
gendiff (-h|--help)
gendiff (-v|--version)
gendiff [--format <fmt>] <firstFile> <secondFile>
```

## Demo
### Input files
#### file1.json
```json
{
  "key1": "value1",
  "key2": true,
  "key3": 123
}
```
#### file2.json
```json
{
  "key1": "value1",
  "key2": false,
  "key4": "new"
}
```
### Stylish format
```bash
gendiff --format stylish file1.json file2.json
```
```bash
{
    key1: value1
  - key2: true
  + key2: false
  - key3: 123
  + key4: new
}
```

### Plain format
```bash
gendiff --format plain file1.json file2.json
```
```bash
Property 'key2' was updated. From true to false
Property 'key3' was removed
Property 'key4' was added with value: 'new'
```

### JSON format
```bash
gendiff --format json file1.json file2.json
```
```json
{
    "key1": {
        "status": "unchanged",
        "value": "value1"
    },
    "key2": {
        "status": "changed",
        "value": {
            "old": true,
            "new": false
        }
    },
    "key3": {
        "status": "removed",
        "value": 123
    },
    "key4": {
        "status": "added",
        "value": "new"
    }
}
```