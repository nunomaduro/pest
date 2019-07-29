<p align="center">

  <img alt="Pest" src="https://raw.githubusercontent.com/nunomaduro/pest/master/docs/banner.png" >

  <p align="center">
    <a href="https://travis-ci.org/nunomaduro/pest"><img src="https://img.shields.io/travis/nunomaduro/pest/master.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/nunomaduro/pest"><img src="https://poser.pugx.org/nunomaduro/pest/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/nunomaduro/pest"><img src="https://poser.pugx.org/nunomaduro/pest/v/stable.svg" alt="Latest Version"></a>
    <a href="https://packagist.org/packages/nunomaduro/pest"><img src="https://poser.pugx.org/nunomaduro/pest/license.svg" alt="License"></a>
  </p>
  <p align="center">
    <strong>For full documentation, visit <a href="https://pest.com">pest.com</a></strong>.
  </p>
</p>

**Pest** was created by, and is maintained by  **[Nuno Maduro](https://github.com/nunomaduro)**  and is an enjoyable **PHP testing solution**. Works out of the box for any PHPUnit project.

## 🚀 Quick start

```
# First, install:
composer require nunomaduro/pest --dev

# Then, use it:
./vendor/bin/pest
```

Create a new under `tests/foo.php`:

```php
it('s awesome', function () {
    assertTrue(Pest::isAwesome());
});
```


## 💖 Support the development
**Do you like this project? Support it by donating**

- PayPal: [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=66BYDWAT92N6L)
- Patreon: [Donate](https://www.patreon.com/nunomaduro)

Pest is open-sourced software licensed under the [MIT license](LICENSE.md).
