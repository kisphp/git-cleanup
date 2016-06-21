# Kisphp Git Cleanup

[![Build Status](https://travis-ci.org/kisphp/git-cleanup.svg?branch=master)](https://travis-ci.org/kisphp/git-cleanup)
[![codecov.io](https://codecov.io/github/kisphp/git-cleanup/coverage.svg?branch=master)](https://codecov.io/github/kisphp/git-cleanup?branch=master)

[![Latest Stable Version](https://poser.pugx.org/kisphp/git-cleanup/v/stable)](https://packagist.org/packages/kisphp/git-cleanup)
[![Total Downloads](https://poser.pugx.org/kisphp/git-cleanup/downloads)](https://packagist.org/packages/kisphp/git-cleanup)
[![License](https://poser.pugx.org/kisphp/git-cleanup/license)](https://packagist.org/packages/kisphp/git-cleanup)
[![Monthly Downloads](https://poser.pugx.org/kisphp/git-cleanup/d/monthly)](https://packagist.org/packages/kisphp/git-cleanup)

## Requirements

To run this tool you need to have at least PHP 5.5.9

## Installation

Include it in your project dev dependencies

```php
composer require kisphp/git-cleanup --dev
```

## Usage

To remove all merged branches or orphan branches run:

```php
vendor/bin/git-cleanup -f
```

To enable verbose mode, append `-v` to the command

```php
vendor/bin/git-cleanup -f -v
```
