# This is module is an abstraction to Magento 2 persistence module, it acts as a middleware that provides a hihg level API to connect a third marty module to Magento.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ticaje/base.svg?style=flat-square)](https://packagist.org/packages/ticaje/persistency)
[![Quality Score](https://img.shields.io/scrutinizer/g/M-Contributions/Core.svg?style=flat-square)](https://scrutinizer-ci.com/g/M-Contributions/Core)
[![Total Downloads](https://img.shields.io/packagist/dt/ticaje/base.svg?style=flat-square)](https://packagist.org/packages/ticaje/base)

## Preface

Magento framework is a great tool for building e-commerce solutions. It did spring out its version 2 some while ago and with it, its quality
jumped up in a tremendous way. Even so, i wanted to provide certain facilities to developers that make live easier when coding in Magento and
repetitive tasks shows up.

I must say that, and perhaps a disclaimer is lurking around, this is a series of extensions developed under S.O.L.I.D and other OO design principles
so we'd introduce some standardization in the way we develop in Magento since its designers took this way when they decided to walk a better path for the
architecture of the framework. In short, S.O.L.I.D principles and good design practices dwell all over Magento ecosystem.

## Installation


You can install this package using composer(the only way i recommend)

```bash
composer require ticaje/base
```

## Features

We're gonna be posting along the way, as we go further in the extension development, the different refactors, base classes and D.R.Y related
stuff that are handy to developers on their daily basis doings.

### Repository base class

This is a simple class that provides typical repository methods for interacting with database.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Héctor Luis Barrientos](https://github.com/ticaje)
- [All Contributors](../../contributors)

## License

The GNU General Public License (GPLv3). Please see [License File](LICENSE.md) for more information.
