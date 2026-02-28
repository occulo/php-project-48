# Gendiff
### Hexlet tests and linter status:
[![Actions Status](https://github.com/occulo/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/occulo/php-project-48/actions) [![PHP CI](https://github.com/occulo/php-project-48/actions/workflows/ci.yml/badge.svg)](https://github.com/occulo/php-project-48/actions/workflows/ci.yml) [![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=occulo_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=occulo_php-project-48)

## Description
Gendiff is a CLI tool and library for generating differences between two configuration files. Supports multiple output formats: stylish, plain, and JSON.

## Prerequisites
* Linux, MacOS, WSL
* PHP >=8.3
* Git
* Composer >=2.0
* Make

## Installation
To get started, run:
```bash
git clone https://github.com/occulo/php-project-48.git
cd php-project-48
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
### Stylish format
[![asciicast](https://asciinema.org/a/1gD5Oba5KFhlsdap.svg)](https://asciinema.org/a/1gD5Oba5KFhlsdap)

### Plain format
[![asciicast](https://asciinema.org/a/Qi56SKgKlavRvUmL.svg)](https://asciinema.org/a/Qi56SKgKlavRvUmL)

### JSON format
[![asciicast](https://asciinema.org/a/TudJipur690UKsdz.svg)](https://asciinema.org/a/TudJipur690UKsdz)