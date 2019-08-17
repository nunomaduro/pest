<?php

declare(strict_types=1);

use NunoMaduro\Pest\Execution;
use NunoMaduro\Pest\Suite;

if (file_exists(__DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php')) {
    include __DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
} else {
    include __DIR__ . '/../../../phpunit/phpunit/src/Framework/Assert/Functions.php';
}

function beforeAll(Closure $closure): void
{
    Execution::beforeAll($closure);
}

function beforeEach(Closure $closure): void
{
    Execution::beforeEach($closure);
}

function test(string $description, Closure $closure): void
{
    Suite::test(sprintf('Test %s', $description), $closure);
}

function it(string $description, Closure $closure): void
{
    Suite::test(sprintf('It %s', $description), $closure);
}

function afterEach(Closure $closure): void
{
    Execution::afterEach($closure);
}

function afterAll(Closure $closure): void
{
    Execution::afterAll($closure);
}
