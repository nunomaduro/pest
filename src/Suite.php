<?php

declare(strict_types=1);

namespace NunoMaduro\Pest;

use Closure;

/**
 * @internal
 */
final class Suite
{
    /**
     * @var Suite
     */
    private static $instance;

    /**
     * @var array<int, ClosureTest>
     */
    public $tests = [];

    /**
     * @var array<string, \Closure>
     */
    public $beforeEach = [];

    /**
     * @var array<string, \Closure>
     */
    public $beforeAll = [];

    /**
     * @var array<string, \Closure>
     */
    public $afterEach = [];

    /**
     * @var array<string, \Closure>
     */
    public $afterAll = [];

    public static function getInstance(): Suite
    {
        return self::$instance ?? (self::$instance = new Suite());
    }

    public static function beforeAll(Closure $closure): void
    {
        self::getInstance()->beforeAll[Reflection::getFileNameFromClosure($closure)] = $closure;
    }

    public static function beforeEach(Closure $closure): void
    {
        self::getInstance()->beforeEach[Reflection::getFileNameFromClosure($closure)] = $closure;
    }

    public static function afterAll(Closure $closure): void
    {
        self::getInstance()->afterAll[Reflection::getFileNameFromClosure($closure)] = $closure;
    }

    public static function afterEach(Closure $closure): void
    {
        self::getInstance()->afterEach[Reflection::getFileNameFromClosure($closure)] = $closure;
    }

    public static function test(string $description, Closure $closure): void
    {
        $file = Reflection::getFileNameFromClosure($closure);

        $instance = self::getInstance();

        $defaultClosure = Closure::fromCallable(function (): void {
        });

        $before = $instance->beforeEach[$file] ?? $defaultClosure;
        $after = $instance->afterEach[$file] ?? $defaultClosure;

        $test = new ClosureTest($file, $description, $closure, $before, $after);

        if (array_key_exists($file, $instance->beforeAll)) {
            $beforeAllClosure = $instance->beforeAll[$file];

            call_user_func($beforeAllClosure);

            unset($instance->beforeAll[$file]);
        }

        $instance->tests[] = $test;
    }
}
