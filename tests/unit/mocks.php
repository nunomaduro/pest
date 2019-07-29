<?php

interface Foo
{
    public function bar(): int;
}

it('works fine with mocks', function () {
    $mock = $this->createMock(Foo::class);

    $mock->expects($this->once())->method('bar')->willReturn(2);

    assertEquals(2, $mock->bar());
});
