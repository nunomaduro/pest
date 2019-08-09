<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/pest/master/art/logo.gif" width="350" alt="PEST">
    <br/>
    <img src="https://raw.githubusercontent.com/nunomaduro/pest/master/art/preview.png" width="882" alt="PEST Preview">
    <p align="center">
        <a href="https://travis-ci.org/nunomaduro/pest"><img src="https://img.shields.io/travis/nunomaduro/pest/master.svg" alt="Build Status"></a>
        <a href="https://packagist.org/packages/nunomaduro/pest"><img src="https://poser.pugx.org/nunomaduro/pest/d/total.svg" alt="Total Downloads"></a>
        <a href="https://packagist.org/packages/nunomaduro/pest"><img src="https://poser.pugx.org/nunomaduro/pest/v/stable.svg" alt="Latest Version"></a>
        <a href="https://packagist.org/packages/nunomaduro/pest"><img src="https://poser.pugx.org/nunomaduro/pest/license.svg" alt="License"></a>
    </p>
</p>

**Pest** was carefully crafted to bring the joy of testing with [JEST](https://github.com/facebook/jest) to PHP. It was created by **[Nuno Maduro](https://github.com/nunomaduro)**, and currently _decorated_ by **[Caneco](https://github.com/caneco)**.

## 🚀 Installation & Usage

> **Requires [PHP 7.2+](https://php.net/releases/) and phpunit 8.1+**

First, Install Pest using [Composer](https://getcomposer.org):

```
composer require nunomaduro/pest --dev
```

Then, create a file named `tests/sum.php`. This will contain our actual test:
```php
test('adds 1 + 2 to equal 3', function () {
    assertEquals(3, Math::sum(1,2));
});
```

Then, as usual, if you don't have it yet, create your `phpunit.xml.dist`.

Finally, run `vendor/bin/pest ` and pest will print this message:

```
PASS  ./sum.php
✓ adds 1 + 2 to equal 3 (5ms)
```

## 📚 Documentation

Pest aims to work out of the box, config free, on most PHP/PHPUnit projects.

Our goal is create a **delightful PHP Testing Framework** with a focus on simplicity - with ideas coming from a line between **[PHPUnit](https://phpunit.de)** and **[Jest](https://jestjs.io)**.

### Writing tests

All you need in a test file is the `test` or `it` method which runs a test. For example, let's say there's a function `inchesOfRain()` that should be `0`. Your whole test could be:

```php
test('did not rain', function () {
    assertEquals(0, Weather::inchesOfRain());
});

# Or, also under the alias `it`
it('did not rain', function () {
    assertEquals(0, Weather::inchesOfRain());
});
```

### Using Assertions

Pest uses "assertions" to let you test values in different ways.

```php
it('has something', (function () {
    assertTrue(true);
    assertFalse(false);
    assertCount(1, ['foo']);
    assertEmpty([]);
    assertEquals('bar', 'bar');
    assertStringContainsString('bar', 'foobarbaz');
    // ...
});
```

For the full list, see the [Assertions documentation from PHPUnit](https://phpunit.readthedocs.io/en/latest/assertions.html).

### Setup and Teardown

Often while writing tests you have some setup work that needs to happen before tests run, and you have some finishing work that needs to happen after tests run. Pest provides helper functions to handle this.

```php
# Runs before each test on this file
beforeEach(function () {
    Database::migrate();
});

# Runs after each test on this file
afterEach(function () {
    Database::delete();
});

test('city database has Vienna', function () {
    assertTrue(City::exists('Vienna'));
});

test('city database has San Juan', function () {
    assertTrue(City::exists('San Juan'));
});
```

### One-Time Setup

In some cases, you only need to do setup once, at the beginning of a file. This can be especially bothersome when the setup is asynchronous, so you can't just do it inline. Pest provides beforeAll and afterAll to handle this situation.

```php
# Runs before the first test of the file
beforeAll(function () {
    Database::migrate();
});

# Runs after the last test of the file
afterAll(function () {
    Database::delete();
});

test('city database has Vienna', function () {
    assertTrue(City::exists('Vienna'));
});

test('city database has San Juan', function () {
    assertTrue(City::exists('San Juan'));
});
```

This may help to illustrate the order of execution:

```php
beforeAll(function () { echo 'beforeAll'); };
afterAll(function () { echo 'afterAll'); };
beforeEach(function () { echo 'beforeEach'); };
afterEach(function () { echo 'afterEach'); };
test('', function () { echo 'test 1'); };
test('', function () { echo 'test 2'); };
// beforeAll
// beforeEach
// test 1
// afterEach
// beforeEach
// test 2
// afterEach
// afterAll
```

### Mocks

The given closure to the `test`|`it` method is bound to a typical `PHPUnit\Framework\TestCase`. For mocks, you
can optionally create a mock using the `$this->createMock` method.

```php
interface Foo
{
    public function bar(): int;
}

it('works fine with mocks', function () {
    $mock = $this->createMock(Foo::class);

    $mock->expects($this->once())->method('bar')->willReturn(2);

    assertEquals(2, $mock->bar());
});
```

### Migrating to Pest from PHPUnit

No migration is needed. It just works.

### Configuration

Pest uses your base `phpunit.xml` configuration file.

## 💖 Support the development
**Do you like this project? Support it by donating**

- PayPal: [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=66BYDWAT92N6L)
- Patreon: [Donate](https://www.patreon.com/nunomaduro)

Pest is open-sourced software licensed under the [MIT license](LICENSE.md).
