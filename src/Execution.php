<?php

declare(strict_types=1);

namespace NunoMaduro\Pest;

use Closure;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite as BaseTestSuite;
use ReflectionFunction;

/**
 * @internal
 */
final class Execution extends BaseTestSuite
{
    /**
     * A custom test case class for running helper methods on.
     *
     * @var TestCase
     */
    private static $customTestCase;

    /**
     * @readonly
     *
     * @var array<int, ClosureTest>
     */
    public static $closureTests = [];

    /**
     * @var array<string, \Closure>
     */
    private static $beforeEach = [];

    /**
     * @var array<string, \Closure>
     */
    private static $beforeAll = [];

    /**
     * @var array<string, \Closure>
     */
    private static $afterEach = [];

    /**
     * @var array<string, \Closure>
     */
    private static $afterAll = [];

    public static function beforeAll(Closure $closure): void
    {
        self::$beforeAll[self::getFileName($closure)] = $closure;
    }

    public static function beforeEach(Closure $closure): void
    {
        self::$beforeEach[self::getFileName($closure)] = $closure;
    }

    public static function afterAll(Closure $closure): void
    {
        self::$afterAll[self::getFileName($closure)] = $closure;
    }

    public static function afterEach(Closure $closure): void
    {
        self::$afterEach[self::getFileName($closure)] = $closure;
    }

    public static function test(string $description, Closure $closure): void
    {
        $file = self::getFileName($closure);

        $before = self::$beforeEach[$file] ?? function () {
            };

        $after = self::$afterEach[$file] ?? function () {
            };

        $test = new ClosureTest($file, $description, $closure, $before, $after, self::$customTestCase);

        if (array_key_exists($file, self::$beforeAll)) {
            $beforeAllClosure = self::$beforeAll[$file];

            call_user_func($beforeAllClosure);

            unset(self::$beforeAll[$file]);
        }

        self::$closureTests[] = $test;
    }

    private static function getFileName(Closure $closure): string
    {
        $reflectionClosure = new ReflectionFunction($closure);

        return (string) $reflectionClosure->getFileName();
    }

    public static function setTestCase(TestCase $testCase): void
    {
        self::$customTestCase = $testCase;
    }
}
