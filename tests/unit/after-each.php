<?php

$foo = new stdClass();
$foo->bar = 1;

afterEach(function () use ($foo) {
    $foo->bar = 2;
});

it('1. gets executed after each test', function () use ($foo) {
    assertEquals(1, $foo->bar);
});

it('2. gets executed after each test', function () use ($foo) {
    assertEquals(2, $foo->bar);
});
