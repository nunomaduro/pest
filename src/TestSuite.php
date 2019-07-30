<?php

declare(strict_types=1);

namespace NunoMaduro\Pest;

use PHPUnit\Framework\TestSuite as BaseTestSuite;

/**
 * @internal
 */
final class TestSuite extends BaseTestSuite
{
    public function __construct()
    {
        parent::__construct();

        foreach (Execution::getClosureTests() as $test) {
            $this->addTest($test);
        }
    }
}
