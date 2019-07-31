<?php

declare(strict_types=1);

namespace NunoMaduro\Pest\Console;

use NunoMaduro\Pest\Execution;
use NunoMaduro\Pest\Extensions\AfterLastTest;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\WarningTestCase;
use PHPUnit\TextUI\Command as BaseCommand;
use PHPUnit\TextUI\ResultPrinter;
use PHPUnit\TextUI\TestRunner;

/**
 * @internal
 */
final class Command extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function handleArguments(array $argv): void
    {
        $this->arguments['printer'] = Printer::class;
        $this->arguments['colors'] = $this->arguments['colors'] ?? ResultPrinter::COLOR_ALWAYS;

        parent::handleArguments($argv);

        /** @var \PHPUnit\Framework\TestSuite $testSuite */
        $testSuite = $this->arguments['test'];

        $this->removeTestClosureWarnings($testSuite);

        foreach (Execution::getClosureTests() as $test) {
            $testSuite->addTest($test);
        }
    }

    protected function createRunner(): TestRunner
    {
        $testRunner = new TestRunner($this->arguments['loader']);

        foreach ([AfterLastTest::class] as $extension) {
            $testRunner->addExtension(new $extension());
        }

        return $testRunner;
    }

    private function removeTestClosureWarnings(TestSuite $testSuite): void
    {
        $tests = $testSuite->tests();

        foreach ($tests as $key => $test) {
            if ($test instanceof TestSuite) {
                $this->removeTestClosureWarnings($test);
            }

            if ($test instanceof WarningTestCase && $test->getMessage() === 'No tests found in class "NunoMaduro\Pest\ClosureTest".') {
                unset($tests[$key]);
            }
        }

        $testSuite->setTests($tests);
    }
}
