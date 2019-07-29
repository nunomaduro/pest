<?php

declare(strict_types=1);

use NunoMaduro\Pest\Exceptions\NotImplementedYet;
use NunoMaduro\Pest\Execution;
use SebastianBergmann\Comparator\TestClass;

include __DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

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
    Execution::test($description, $closure);
}

function it(string $description, Closure $closure): void
{
    Execution::test($description, $closure);
}

function afterEach(Closure $closure): void
{
    Execution::afterEach($closure);
}

function afterAll(Closure $closure): void
{
    throw new NotImplementedYet('Not implemented yet.');
}
