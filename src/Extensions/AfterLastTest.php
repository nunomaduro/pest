<?php

declare(strict_types=1);

namespace NunoMaduro\Pest\Extensions;

use NunoMaduro\Pest\Suite;
use PHPUnit\Runner\AfterLastTestHook;

/**
 * @internal
 */
final class AfterLastTest implements AfterLastTestHook
{
    public function executeAfterLastTest(): void
    {
        foreach (Suite::getInstance()->afterAll as $closure) {
            call_user_func($closure);
        }
    }
}
