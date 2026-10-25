<?php

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Livewire;
use Orion\FilamentGreeter\GreeterPlugin;
use Orion\FilamentGreeter\GreeterWidget;

beforeEach(function () {
    $this->signIn();
});

it('renders the name, title, avatar and custom action', function () {
    $this->usePanelWith(
        GreeterPlugin::make()
            ->name('Jane Doe')
            ->title('Administrator')
            ->avatar(size: 'xl', url: 'https://example.com/avatar.png')
            ->action(Action::make('newPost')->label('New Post')->url('https://example.com/posts/create'))
    );

    Livewire::test(GreeterWidget::class)
        ->assertOk()
        ->assertSee('Jane Doe')
        ->assertSee('Administrator')
        ->assertSee('New Post')
        ->assertSeeHtml('src="https://example.com/avatar.png"')
        ->assertSeeHtml('style="width: 3.5rem; height: 3.5rem;"')
        ->assertSeeHtml('href="https://example.com/posts/create"')
        ->assertSeeHtml('fi-labeled-from-sm')
        ->assertDontSee(__('filament-panels::widgets/account-widget.actions.logout.label'));
});

it('falls back to the signed in user, their avatar and a logout button', function () {
    $this->usePanelWith(GreeterPlugin::make());

    Livewire::test(GreeterWidget::class)
        ->assertSee('Welcome')
        ->assertSee('John Doe')
        ->assertSeeHtml('src="https://ui-avatars.com/api/?name=J+D')
        ->assertDontSeeHtml('style=";"')
        ->assertSee(__('filament-panels::widgets/account-widget.actions.logout.label'))
        ->assertSeeHtml('fi-account-widget-logout-form');
});

it('renders a custom message before the name and title', function () {
    $this->usePanelWith(
        GreeterPlugin::make()
            ->message('Welcome back,')
            ->name('Jane Doe')
            ->title('Administrator')
    );

    Livewire::test(GreeterWidget::class)
        ->assertSeeInOrder(['Welcome back,', 'Jane Doe', 'Administrator']);
});

it('shows the name as the subtitle when the title is disabled', function () {
    $this->usePanelWith(
        GreeterPlugin::make()
            ->name('Jane Doe')
            ->title('Administrator', enabled: false)
    );

    Livewire::test(GreeterWidget::class)
        ->assertSeeInOrder(['Welcome', 'Jane Doe'])
        ->assertDontSee('Administrator');
});

it('can hide the avatar', function () {
    $this->usePanelWith(GreeterPlugin::make()->avatar(enabled: false));

    Livewire::test(GreeterWidget::class)
        ->assertDontSeeHtml('fi-avatar');
});

it('runs a custom action', function () {
    $this->usePanelWith(
        GreeterPlugin::make()->action(
            Action::make('publish')
                ->label('Publish')
                ->action(fn () => Notification::make()->title('Published')->success()->send())
        )
    );

    Livewire::test(GreeterWidget::class)
        ->assertSee('Publish')
        ->callAction('publish')
        ->assertNotified('Published');
});

it('confirms a custom action through its modal', function () {
    $this->usePanelWith(
        GreeterPlugin::make()->action(
            Action::make('publish')
                ->label('Publish')
                ->requiresConfirmation()
                ->action(fn () => Notification::make()->title('Published')->success()->send())
        )
    );

    Livewire::test(GreeterWidget::class)
        ->assertSeeHtml('wire:partial="action-modals"')
        ->mountAction('publish')
        ->assertActionMounted('publish')
        ->callMountedAction()
        ->assertNotified('Published');
});

it('hides an invisible custom action', function () {
    $this->usePanelWith(
        GreeterPlugin::make()->action(Action::make('hidden')->label('Hidden action')->visible(false))
    );

    Livewire::test(GreeterWidget::class)
        ->assertDontSee('Hidden action');
});

it('spans one column by default', function () {
    $this->usePanelWith(GreeterPlugin::make());

    Livewire::test(GreeterWidget::class)
        ->assertSeeHtml('span 1 / span 1;');
});

it('takes its visibility, sort and column span from the plugin', function () {
    $this->usePanelWith(
        GreeterPlugin::make()
            ->visible(fn () => false)
            ->sort(7)
            ->columnSpan('full')
    );

    expect(GreeterWidget::canView())->toBeFalse()
        ->and(GreeterWidget::getSort())->toBe(7)
        ->and((new GreeterWidget)->getColumnSpan())->toBe('full');
});
