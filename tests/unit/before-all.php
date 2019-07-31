<?php

$foo = new \stdClass();

beforeAll(function () use ($foo) {
    $foo->bar = 2;
});

it('1. gets executed before all tests', function () use ($foo) {
    assertEquals($foo->bar, 2);

    $foo->bar = 'changed';
});

it('2. gets executed before all tests', function () use ($foo) {
    assertEquals($foo->bar, 'changed');
});
