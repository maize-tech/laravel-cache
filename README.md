# Package in development. Not use in production

# Laravel cache

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maize-tech/laravel-cache.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-cache)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/maize-tech/laravel-cache/run-tests?label=tests)](https://github.com/maize-tech/laravel-cache/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/maize-tech/laravel-cache/Check%20&%20fix%20styling?label=code%20style)](https://github.com/maize-tech/laravel-cache/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maize-tech/laravel-cache.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-cache)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require maize-tech/laravel-cache
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-cache-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$cache = new Maize\Cache();
echo $cache->echoPhrase('Hello, Maize!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Enrico De Lazzari](https://github.com/enricodelazzari)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
