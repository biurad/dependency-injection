# The Biurad PHP Dependency Injection

[![Latest Version](https://img.shields.io/packagist/v/biurad/dependency-injection.svg?style=flat-square)](https://packagist.org/packages/biurad/dependency-injection)
[![Software License](https://img.shields.io/badge/License-BSD--3-brightgreen.svg?style=flat-square)](LICENSE)
[![Workflow Status](https://img.shields.io/github/workflow/status/biurad/php-dependency-injection/Tests?style=flat-square)](https://github.com/biurad/php-dependency-injection/actions?query=workflow%3ATests)
[![Code Maintainability](https://img.shields.io/codeclimate/maintainability/biurad/php-dependency-injection?style=flat-square)](https://codeclimate.com/github/biurad/php-dependency-injection)
[![Coverage Status](https://img.shields.io/codecov/c/github/biurad/php-dependency-injection?style=flat-square)](https://codecov.io/gh/biurad/php-dependency-injection)
[![Quality Score](https://img.shields.io/scrutinizer/g/biurad/php-dependency-injection.svg?style=flat-square)](https://scrutinizer-ci.com/g/biurad/php-dependency-injection)
[![Sponsor development of this project](https://img.shields.io/badge/sponsor%20this%20package-%E2%9D%A4-ff69b4.svg?style=flat-square)](https://biurad.com/sponsor)

**biurad/php-dependency-injection** is a powerful tool for managing class dependencies and performing dependency injection for [PHP] 7.2+ created by [Divine Niiquaye][@divineniiquaye] based on The [Nette DI][nette-di]. This library provides a fancy phrase that essentially means this: class dependencies are "injected" into the class via the constructor or, in some cases, "setter" methods.

## 📦 Installation & Basic Usage

This project requires [PHP] 7.2 or higher. The recommended way to install, is via [Composer]. Simply run:

```bash
$ composer require biurad/dependency-injection
```

### How To Use

A deep understanding of the Dependency Injection is essential to building a powerful, large application, as well as for contributing to this library core itself. This README is focused on the new features added to [Nette Di][nette-di].

This dependency is an extended version of [Nette Di][nette-di] which has been simplified for developer's convenient. With this bridge, more features have been implemented to have a fast and flexible Dependency Injection Container.

> Container implementation is fully compatible with [PSR-11 Container](https://github.com/php-fig/container).

### PSR-11 Container

You can always access container directly in your code by requesting `Psr\Container\ContainerInterface`:

```php
use Psr\Container\ContainerInterface;

class HomeContoller
{
    public function index(ContainerInterface $container)
    {
        var_dump($container->get(App\Kernel::class));
    }
}
```

## 📓 Documentation

For in-depth documentation before using this library. Full documentation on advanced usage, configuration, and customization can be found at [docs.biurad.com][docs].

## ⏫ Upgrading

Information on how to upgrade to newer versions of this library can be found in the [UPGRADE].

## 🏷️ Changelog

[SemVer](http://semver.org/) is followed closely. Minor and patch releases should not introduce breaking changes to the codebase; See [CHANGELOG] for more information on what has changed recently.

Any classes or methods marked `@internal` are not intended for use outside of this library and are subject to breaking changes at any time, so please avoid using them.

## 🛠️ Maintenance & Support

When a new **major** version is released (`1.0`, `2.0`, etc), the previous one (`0.19.x`) will receive bug fixes for _at least_ 3 months and security updates for 6 months after that new release comes out.

(This policy may change in the future and exceptions may be made on a case-by-case basis.)

**Professional support, including notification of new releases and security updates, is available at [Biurad Commits][commit].**

## 👷‍♀️ Contributing

To report a security vulnerability, please use the [Biurad Security](https://security.biurad.com). We will coordinate the fix and eventually commit the solution in this project.

Contributions to this library are **welcome**, especially ones that:

- Improve usability or flexibility without compromising our ability to adhere to ???.
- Optimize performance
- Fix issues with adhering to ???.
- ???.

Please see [CONTRIBUTING] for additional details.

## 🧪 Testing

```bash
$ composer test
```

This will tests biurad/php-dependency-injection will run against PHP 7.2 version or higher.

## 👥 Credits & Acknowledgements

- [Divine Niiquaye Ibok][@divineniiquaye]
- [All Contributors][]

## 🙌 Sponsors

Are you interested in sponsoring development of this project? Reach out and support us on [Patreon](https://www.patreon.com/biurad) or see <https://biurad.com/sponsor> for a list of ways to contribute.

## 📄 License

**biurad/php-dependency-injection** is licensed under the BSD-3 license. See the [`LICENSE`](LICENSE) file for more details.

## 🏛️ Governance

This project is primarily maintained by [Divine Niiquaye Ibok][@divineniiquaye]. Members of the [Biurad Lap][] Leadership Team may occasionally assist with some of these duties.

## 🗺️ Who Uses It?

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us an [email] or [message] mentioning this library. We publish all received request's at <https://patreons.biurad.com>.

Check out the other cool things people are doing with `biurad/php-dependency-injection`: <https://packagist.org/packages/biurad/dependency-injection/dependents>

[PHP]: https://php.net
[Composer]: https://getcomposer.org
[@divineniiquaye]: https://github.com/divineniiquaye
[docs]: https://docs.biurad.com/php-dependency-injection
[commit]: https://commits.biurad.com/php-dependency-injection.git
[UPGRADE]: UPGRADE-1.x.md
[CHANGELOG]: CHANGELOG-0.x.md
[CONTRIBUTING]: ./.github/CONTRIBUTING.md
[All Contributors]: https://github.com/biurad/php-dependency-injection/contributors
[Biurad Lap]: https://team.biurad.com
[email]: support@biurad.com
[message]: https://projects.biurad.com/message
[nette-di]: https://github.com/nette/di
