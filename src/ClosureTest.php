<?php

declare(strict_types=1);

namespace NunoMaduro\Pest;

use Closure;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ClosureTest extends TestCase
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Closure
     */
    private $test;

    /**
     * @var \Closure
     */
    private $before;

    /**
     * @var \Closure
     */
    private $after;

    /**
     * A custom test case class for running helper methods on.
     *
     * @var TestCase
     */
    private $customTestCase;

    public function __construct(
        string $file,
        string $description,
        Closure $test,
        Closure $before,
        Closure $after,
        ?TestCase $customTestCase
    )
    {
        parent::__construct('__invoke');

        $this->file = $file;
        $this->description = $description;
        $this->test = $test;
        $this->before = $before;
        $this->after = $after;
        $this->customTestCase = $customTestCase;
    }

    public function setUp(): void
    {
        parent::setUp();
        if ($this->customTestCase !== null) {
            $this->customTestCase->setUp();
        }

        call_user_func(Closure::bind($this->before, $this, static::class));
    }

    public function tearDown(): void
    {
        parent::tearDown();
        if ($this->customTestCase !== null) {
            $this->customTestCase->tearDown();
        }

        call_user_func(Closure::bind($this->after, $this, static::class));
    }

    public function __invoke(): void
    {
        call_user_func(Closure::bind($this->test, $this, static::class));
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function getName(bool $withDataSet = true): string
    {
        return $this->description;
    }

    public function toString(): string
    {
        return \sprintf(
            '%s::%s',
            $this->file,
            $this->description
        );
    }

    public function __call($name, $arguments)
    {
        return $this->customTestCase->$name(...$arguments);
    }
}
