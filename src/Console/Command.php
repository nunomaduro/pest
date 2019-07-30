<?php

declare(strict_types=1);

namespace NunoMaduro\Pest\Console;

use NunoMaduro\Pest\TestSuite;
use PHPUnit\TextUI\Command as BaseCommand;
use PHPUnit\TextUI\ResultPrinter;

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
        $this->arguments['test'] = new TestSuite();
    }
}
