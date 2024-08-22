<?php

namespace Orion\FilamentGreeter;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GreeterPluginServiceProvider extends PackageServiceProvider
{
    public static string $name = 'greeter';

    public static string $viewNamespace = 'greeter';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews(static::$viewNamespace);

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }
    }

    public function packageBooted(): void
    {
        Livewire::component('greeter-widget', GreeterWidget::class);
    }
}
