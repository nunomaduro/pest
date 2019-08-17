<?php

declare(strict_types=1);

namespace NunoMaduro\Pest;

use Closure;
use ReflectionFunction;

/**
 * @internal
 */
final class Execution
{
    /**
     * @readonly
     *
     * @var array<string, \Closure>
     */
    public static $beforeEach = [];

    /**
     * @readonly
     *
     * @var array<string, \Closure>
     */
    public static $beforeAll = [];

    /**
     * @readonly
     *
     * @var array<string, \Closure>
     */
    public static $afterEach = [];

    /**
     * @readonly
     *
     * @var array<string, \Closure>
     */
    public static $afterAll = [];

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

    public static function getFileName(Closure $closure): string
    {
        $reflectionClosure = new ReflectionFunction($closure);

        return (string) $reflectionClosure->getFileName();
    }
}
