# Craft relax! Less database I/O 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ostark/craft-relax.svg?style=flat-square)](https://packagist.org/packages/ostark/craft-relax)
[![Total Downloads](https://img.shields.io/packagist/dt/ostark/craft-relax.svg?style=flat-square)](https://packagist.org/packages/ostark/craft-relax)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen)](https://plant.treeware.earth/ostark/craft-relax)

---
This repo can be used to scaffold a Craft plugin. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this craft-relax
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files
3. Remove this block of text.

(This template is heavily inspired by [Spatie's PHP craft-relax](https://github.com/spatie/package-craft-relax-php))




---

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require ostark/craft-relax
php craft plugin/install relax
```

## Usage

```php
$craft-relax = new ostark\Relax();
echo $craft-relax->echoPhrase('Hello, ostark!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Oliver Stark](https://github.com/ostark)
- [All Contributors](../../contributors)

## License

License: MIT
Please see [License File](LICENSE.md) for more information.
