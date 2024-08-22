<?php

namespace Orion\FilamentGreeter;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\AccountWidget;

class GreeterWidget extends AccountWidget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static string $view = 'greeter::widget';

    public function action()
    {
        return GreeterPlugin::get()->getAction();
    }

    public static function canView(): bool
    {
        return GreeterPlugin::get()->isVisible();
    }

    public static function getSort(): int
    {
        return GreeterPlugin::get()->getSort();
    }

    public function getColumnSpan(): int | string | array
    {
        return GreeterPlugin::get()->getColumnSpan();
    }
}
