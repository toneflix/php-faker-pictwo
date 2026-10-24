# Faker PicTwo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/toneflix/faker-pictwo.svg?style=flat-square)](https://packagist.org/packages/toneflix/faker-pictwo)
[![Tests](https://github.com/toneflix/fakerphp-lorem-toneflix/actions/workflows/run-tests.yml/badge.svg)](https://github.com/toneflix/fakerphp-lorem-toneflix/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/toneflix/faker-pictwo.svg?style=flat-square)](https://packagist.org/packages/toneflix/faker-pictwo)

## Introduction

Alternative image provider for [fakerphp](https://github.com/fakerphp/faker) using [pictwo.toneflix.net](https://pictwo.toneflix.net)

## Installation

You can install the package via composer in dev dependency section:

```bash
composer require --dev toneflix/faker-pictwo
```

## Usage

```php
$faker = \Faker\Factory::create();
$faker->addProvider(new \Toneflix\FakerPicTwo\FakerPicTwoProvider($faker));

// return a string that contains a url like 'https://pictwo.toneflix.net/images/avatar?w=800&h=600'
$faker->imageUrl(width: 800, height: 600, category: 'avatar');

// download a properly sized image from pictwo.toneflix.net into a file with a file path like '/tmp/13b73edae8443990be1aa8f1a483bc27.jpg'
$filePath= $faker->image(dir: '/tmp', width: 640, height: 480);
```

Also, there are some more options :

-   effects (grayscale, pixelate)
-   returning a specific photo based on an id instead of a random one (ex: https://pictwo.toneflix.net/images/image/00020)

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Toneflix Code](https://github.com/toneflix)
-   [Legacy ](https://github.com/3m1n3nc3)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
