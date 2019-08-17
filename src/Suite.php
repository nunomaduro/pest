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
     * @return array<int, ClosureTest>
     */
    public function getTests(): array
    {
        return $this->tests;
    }

    public static function getInstance(): Suite
    {
        return self::$instance ?? (self::$instance = new Suite());
    }

    public static function test(string $description, Closure $closure): void
    {
        $file = Execution::getFileName($closure);

        $defaultClosure = Closure::fromCallable(function (): void {
        });

        $before = Execution::$beforeEach[$file] ?? $defaultClosure;
        $after = Execution::$afterEach[$file] ?? $defaultClosure;

        $test = new ClosureTest($file, $description, $closure, $before, $after);

        if (array_key_exists($file, Execution::$beforeAll)) {
            $beforeAllClosure = Execution::$beforeAll[$file];

            call_user_func($beforeAllClosure);

            unset(Execution::$beforeAll[$file]);
        }

        self::getInstance()->tests[] = $test;
    }
}
