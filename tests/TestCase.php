<?php

namespace Orion\FilamentGreeter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
