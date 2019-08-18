<?php

declare(strict_types=1);

namespace NunoMaduro\Pest;

use Closure;
use ReflectionFunction;

/**
 * @internal
 */
final class Reflection
{
    public static function getFileNameFromClosure(Closure $closure): string
    {
        $reflectionClosure = new ReflectionFunction($closure);

        return (string) $reflectionClosure->getFileName();
    }
}
