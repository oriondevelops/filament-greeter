# A Filament plugin to greet your users

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oriondevelops/filament-greeter.svg?style=flat-square)](https://packagist.org/packages/oriondevelops/filament-greeter)
[![Total Downloads](https://img.shields.io/packagist/dt/oriondevelops/filament-greeter.svg?style=flat-square)](https://packagist.org/packages/oriondevelops/filament-greeter)

This Filament plugin is the sibling of [nova-greeter](https://github.com/oriondevelops/nova-greeter) that extends the default account widget and lets you:

- Give yourself and your users fancy titles
- Add a custom action
- Change welcome message
- Change avatar size
- Disable avatar

![example-daenerys](https://raw.githubusercontent.com/oriondevelops/filament-greeter/main/docs/example-daenerys.png)

## Installation

You can install the package via composer:

```bash
composer require oriondevelops/filament-greeter
```

## Usage

You need to register the plugin with your preferred Filament panel providers. This can be done inside your `PanelProvider`, e.g. `AdminPanelProvider`.

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Orion\FilamentBackup\BackupPlugin;
use Orion\FilamentGreeter\GreeterPlugin;
use Orion\FilamentFeedback\FeedbackPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugins([
                BackupPlugin::make()
                    ->queue('monitors'),
                // ...    
                GreeterPlugin::make()
                    ->message('Welcome,')
                    ->name('Daenerys Targaryen')
                    ->title('The First of Her Name, the Unburnt, Queen of Meereen, Queen of the Andals and the Rhoynar and the First Men, Khalisee of the Great Grass Sea, Breaker of Chains and Mother of Dragons')
                    ->avatar(size: 'w-16 h-16', url: 'https://avatarfiles.alphacoders.com/236/236674.jpg')
                    ->action(
                        Action::make('action')
                            ->label('Buy more unsullied')
                            ->icon('heroicon-o-shopping-cart')
                            ->url('https://buyunsulliedonline.com')
                    )
                    ->sort(-1)
                    ->columnSpan('full'),
                // ...
                FeedbackPlugin::make()
                    ->sendResponsesTo(email: 'oriondevelops@gmail.com'),
            ])
    }
}
```

**Message**

```php
->message(text: 'Welcome')
```

**Time-Sensitive Greeting**

```php
->timeSensitive(morningStart: 6, afternoonStart: 12, eveningStart: 17, nightStart: 22)
```

The greeting message will change to "Good morning", "Good afternoon", "Good evening", or "Good night" based on the current time. You can omit the hour parameters to use the default times.

**Title**

```php
->title(text: 'Administrator', enabled: true)
```

**Avatar**

[Setting up user avatars](https://filamentphp.com/docs/3.x/panels/users#setting-up-user-avatars)

```php
->avatar(size: 'lg', enabled: true),
```

**Action**

```php
->action(
    Action::make('action')
        ->label('Buy more unsullied')
        ->icon('heroicon-o-shopping-cart')
        ->url('https://buyunsulliedonline.com')
)
```

## Examples

![example-rand](https://raw.githubusercontent.com/oriondevelops/filament-greeter/main/docs/example-rand.png)

```
GreeterPlugin::make()
    ->message('Welcome')
    ->name("Rand al'Thor")
    ->title("Dragon Reborn, Coramoor, Car'a'carn, He Who Comes With the Dawn, Shadowkiller, King of Illian, Lord of the Morning")
    ->avatar(size: 'w-16 h-16')
    ->columnSpan('full')
    ->action(
        Action::make('action')
            ->label('Reborn')
            ->color('danger')
            ->icon('heroicon-o-arrow-path')
            ->action(function () {
                Notification::make()
                    ->title('Reborn successfully')
                    ->success()
                    ->send();
            })
    ),
```

![example-annatar](https://raw.githubusercontent.com/oriondevelops/filament-greeter/main/docs/example-annatar.png)

```
GreeterPlugin::make()
    ->message('Welcome')
    ->name("Annatar")
    ->action(
        Action::make('action')
            ->label('Gift a ring')
            ->color('warning')
            ->icon('heroicon-o-gift')
            ->action(function () {
                Notification::make()
                    ->title('Target deceived successfully')
                    ->warning()
                    ->send();
            })
    ),
```

![example-no-avatar](https://raw.githubusercontent.com/oriondevelops/filament-greeter/main/docs/example-no-avatar.png)

```
GreeterPlugin::make()
    ->avatar(enabled: false),
```

![example-dayne](https://raw.githubusercontent.com/oriondevelops/filament-greeter/refs/heads/main/docs/example-dayne.png)

```
GreeterPlugin::make()
    ->timeSensitive()
    ->name('Ser Arthur Dayne')
    ->title('Sword of the Morning')
    ->avatar(size: 'w-16 h-16')
    ->columnSpan('full')
    ->action(
        Action::make('action')
            ->label('Protect the Heir')
            ->icon('heroicon-o-shield-check')
            ->action(fn () => Notification::make()->title('You failed! You’ve been stabbed in the back.')->danger()->send())
    ),
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [Security Policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Mücahit Uğur](https://github.com/oriondevelops)
- [All Contributors](https://github.com/oriondevelops/filament-greeter/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
