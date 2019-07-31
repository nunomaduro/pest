<?php

declare(strict_types=1);

namespace NunoMaduro\Pest\Extensions;

use NunoMaduro\Pest\Execution;
use PHPUnit\Runner\AfterLastTestHook;

/**
 * @internal
 */
final class AfterLastTest implements AfterLastTestHook
{
    public function executeAfterLastTest(): void
    {
        foreach (Execution::$afterAll as $closure) {
            call_user_func($closure);
        }
    }
}
