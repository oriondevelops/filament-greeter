<?php

use Carbon\Carbon;
use Orion\FilamentGreeter\GreeterPlugin;

it('returns correct greeting based on hours', function (int $currentHour, string $expectedKey, int $morningStart, int $afternoonStart, int $eveningStart, int $nightStart) {
    Carbon::setTestNow(Carbon::create(2024, 1, 1, $currentHour, 0, 0));

    $plugin = GreeterPlugin::make()
        ->timeSensitive($morningStart, $afternoonStart, $eveningStart, $nightStart);

    expect($plugin->getMessage())->toBe('greeter::widget.' . $expectedKey);
})->with([
    // Default settings
    [5, 'night', 6, 12, 17, 22],
    [6, 'morning', 6, 12, 17, 22],
    [11, 'morning', 6, 12, 17, 22],
    [12, 'afternoon', 6, 12, 17, 22],
    [16, 'afternoon', 6, 12, 17, 22],
    [17, 'evening', 6, 12, 17, 22],
    [21, 'evening', 6, 12, 17, 22],
    [22, 'night', 6, 12, 17, 22],
    [23, 'night', 6, 12, 17, 22],
    [0, 'night', 6, 12, 17, 22],

    // Custom settings
    [4, 'night', 5, 13, 18, 23],
    [5, 'morning', 5, 13, 18, 23],
    [12, 'morning', 5, 13, 18, 23],
    [13, 'afternoon', 5, 13, 18, 23],
    [17, 'afternoon', 5, 13, 18, 23],
    [18, 'evening', 5, 13, 18, 23],
    [22, 'evening', 5, 13, 18, 23],
    [23, 'night', 5, 13, 18, 23],
    [0, 'night', 5, 13, 18, 23],

    // Edge cases
    [0, 'night', 1, 12, 18, 0],
    [23, 'evening', 1, 12, 18, 0],
    [0, 'morning', 0, 12, 18, 23],
    [23, 'night', 0, 12, 18, 23],
]);
