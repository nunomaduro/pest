<?php

beforeEach(function () {
    $this->bar = 2;
});

it('1. gets executed before each test', function () {
    assertEquals($this->bar, 2);

    $this->bar = 'changed';
});

it('2. gets executed before each test', function () {
    assertEquals($this->bar, 2);
});
