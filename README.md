# PHPUnit Patch Serializable Comparison [![Status](https://github.com/mpyw/phpunit-patch-serializable-comparison/actions/workflows/test.yml/badge.svg?branch=master)](https://github.com/mpyw/phpunit-patch-serializable-comparison/actions)

Fixes `assertSame()`/`assertEquals()` serialization errors running in separate processes.

## Requirements

- php: `>=7.4`
- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): `=9.5`
- [sebastianbergmann/comparator](https://github.com/sebastianbergmann/comparator): `^4.0`

## Installing

```bash
composer require --dev phpfan/phpunit-patch
```

## Example

```php
class AssertionTest extends TestCase
{
    protected function callAssertSameReceivingClosure(\Closure $closure)
    {
        static::assertSame('aaa', 'bbb');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testAssertionIncludingUnserializableTrace()
    {
        static::callAssertSameInClosure(function () {});
    }
}
```

### Before Patching

```
PHPUnit\Framework\Exception: PHP Fatal error:  Uncaught Exception: Serialization of 'Closure' is not allowed in Standard input code:XX
Stack trace:
#0 Standard input code(XX): serialize(Array)
#1 Standard input code(XX): __phpunit_run_isolated_test()
#2 {main}
  thrown in Standard input code on line XX
```

### After Patching

```diff
Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'aaa'
+'bbb'
```
