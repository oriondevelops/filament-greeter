<?php

namespace Orion\FilamentGreeter;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Widgets\AccountWidget;

class GreeterWidget extends AccountWidget implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    protected string $view = 'greeter::widget';

    protected ?Action $greeterAction = null;

    public function booted(): void
    {
        if (($action = GreeterPlugin::get()->getAction()) instanceof Action) {
            $this->greeterAction = $this->cacheAction((clone $action)->labeledFrom('sm'));
        }
    }

    public function getGreeterAction(): ?Action
    {
        return $this->greeterAction;
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
