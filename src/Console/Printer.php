<?php

declare(strict_types=1);

namespace NunoMaduro\Pest\Console;

use NunoMaduro\Pest\ClosureTest;
use PHPUnit\Framework\Test;
use PHPUnit\Runner\BaseTestRunner;
use PHPUnit\Runner\PhptTestCase;
use PHPUnit\Runner\Version;
use PHPUnit\Util\Color;
use PHPUnit\Util\TestDox\CliTestDoxPrinter;

/**
 * @internal
 */
final class Printer extends CliTestDoxPrinter
{
    private const STATUS_STYLES = [
        BaseTestRunner::STATUS_PASSED => [
            'symbol' => 'PASS',
            'color' => 'bg-green,fg-black',
        ],
        BaseTestRunner::STATUS_ERROR => [
            'symbol' => '✘',
            'color' => 'fg-yellow',
            'message' => 'bg-yellow,fg-black',
        ],
        BaseTestRunner::STATUS_FAILURE => [
            'symbol' => '✘',
            'color' => 'fg-red',
            'message' => 'bg-red,fg-white',
        ],
        BaseTestRunner::STATUS_SKIPPED => [
            'symbol' => '↩',
            'color' => 'fg-cyan',
            'message' => 'fg-cyan',
        ],
        BaseTestRunner::STATUS_RISKY => [
            'symbol' => '☢',
            'color' => 'fg-yellow',
            'message' => 'fg-yellow',
        ],
        BaseTestRunner::STATUS_INCOMPLETE => [
            'symbol' => '∅',
            'color' => 'fg-yellow',
            'message' => 'fg-yellow',
        ],
        BaseTestRunner::STATUS_WARNING => [
            'symbol' => '⚠',
            'color' => 'fg-yellow',
            'message' => 'fg-yellow',
        ],
        BaseTestRunner::STATUS_UNKNOWN => [
            'symbol' => '?',
            'color' => 'fg-blue',
            'message' => 'fg-white,bg-blue',
        ],
    ];

    protected function formatClassName(Test $test): string
    {
        if (! $test instanceof ClosureTest) {
            return \get_class($test);
        }

        $file = $test->getFile();
        $relativeFile = explode('/tests/', $file)[1];
        $parts = explode('/', $relativeFile);
        $last = array_pop($parts);
        return Color::dim(implode('/', $parts)) . '/' . $last;
    }

    public function write(string $buffer): void
    {
        if ($buffer === Version::getVersionString() . "\n") {
            return;
        }

        parent::write($buffer);
    }

    /**
     * {@inheritdoc}
     */
    protected function writeTestResult(array $prevResult, array $result): void
    {
        // spacer line for new suite headers and after verbose messages
        if ($prevResult['testName'] !== '' &&
            ($prevResult['message'] !== '' || $prevResult['className'] !== $result['className'])) {
            $this->write(\PHP_EOL);
        }

        // suite header
        if ($prevResult['className'] !== $result['className']) {
            $this->write($this->colorizeTextBox(
                'underlined',
                $result['className']
            ) . \PHP_EOL);
        }

        // test result line
        $testName = $result['testMethod'];
        if ($this->colors && $result['className'] === PhptTestCase::class) {
            $testName = Color::colorizePath(
                $result['testName'],
                $prevResult['testName'],
                true
            );
        }

        $style = self::STATUS_STYLES[$result['status']];

        $time = '';
        if ($this->verbose) {
            $formattedTime = $this->formatRuntime($result['time'], 'fg-white');
            $time = ' (' . trim($formattedTime) . ')';
        }

        $line = \sprintf(
            ' %s %s%s' . \PHP_EOL,
            $this->colorizeTextBox($style['color'], $style['symbol']),
            $testName,
            $time
        );

        $this->write($line);

        $this->write($result['message']);
    }

    private function formatRuntime(float $time, string $color = ''): string
    {
        if (! $this->colors) {
            return \sprintf('[%.2f ms]', $time * 1000);
        }

        if ($time > 1) {
            $color = 'fg-magenta';
        }

        return Color::colorize($color, (int) \ceil($time * 1000) . ' ' . Color::dim('ms'));
    }
}
