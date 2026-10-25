<?php

namespace Orion\FilamentGreeter\Tests;

use Filament\Facades\Filament;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase as Orchestra;
use Orion\FilamentGreeter\GreeterPlugin;
use Orion\FilamentGreeter\Tests\Fixtures\AdminPanelProvider;

abstract class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:' . base64_encode(random_bytes(32)));
    }

    protected function getPackageProviders($app): array
    {
        return [
            AdminPanelProvider::class,
        ];
    }

    protected function usePanelWith(GreeterPlugin $plugin): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin')->plugin($plugin));
    }

    protected function signIn(): void
    {
        $this->actingAs((new User)->forceFill(['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com']));
    }
}
