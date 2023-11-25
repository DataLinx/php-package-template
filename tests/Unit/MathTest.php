<?php

use DataLinx\PhpPackageTemplate\Math;

test('it adds two numbers', function () {
    expect(Math::add(1, 2))->toBe(3);
});

test('it subtracts two numbers', function () {
    expect(Math::subtract(2, 1))->toBe(1);
});

test('it multiplies two numbers', function () {
    expect(Math::multiply(2, 2))->toBe(4);
});
