# Craft relax! Less database I/O 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ostark/craft-relax.svg?style=flat-square)](https://packagist.org/packages/ostark/craft-relax)
[![Total Downloads](https://img.shields.io/packagist/dt/ostark/craft-relax.svg?style=flat-square)](https://packagist.org/packages/ostark/craft-relax)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen)](https://plant.treeware.earth/ostark/craft-relax)

The plugin tries to reduce write I/O on the database in multiple ways. It prevents servers from being overwhelmed by too many queue messages, the search index becomes leaner by skipping useless terms, and deprecation notices are written in dev environments only.
In result the database is more relaxed and can handle more queries faster, which leads to faster sites.


## Installation

You can install the package via composer:

```bash
composer require ostark/craft-relax
php craft plugin/install relax
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
