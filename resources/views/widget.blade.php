@php
    use Filament\Support\Icons\Heroicon;
    use Filament\View\PanelsIconAlias;
    use Illuminate\View\ComponentAttributeBag;

    $user = filament()->auth()->user();
    $plugin = filament('filament-greeter');
    $name = $plugin->getName() ?? filament()->getUserName($user);
    $message = $plugin->getMessage();
    $avatarSize = $plugin->getAvatarSize();
    $avatarStyle = match ($avatarSize) {
        'xl' => 'width: 3.5rem; height: 3.5rem',
        '2xl' => 'width: 4rem; height: 4rem',
        default => null,
    };
    $action = $this->getGreeterAction();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        @if ($plugin->shouldHaveAvatar())
            <x-filament::avatar
                :src="$plugin->getAvatarUrl() ?? filament()->getUserAvatarUrl($user)"
                :alt="__('filament-panels::layout.avatar.alt', ['name' => $name])"
                :size="$avatarStyle ? 'md' : $avatarSize"
                :attributes="new ComponentAttributeBag(array_filter(['style' => $avatarStyle]))"
                class="fi-user-avatar"
                loading="lazy"
            />
        @endif

        <div class="fi-account-widget-main">
            <h2 class="fi-account-widget-heading">
                {{ $message ?? __('greeter::widget.message') }}
                @if ($plugin->shouldHaveTitle())
                    {{ $name }}
                @endif
            </h2>

            <p class="fi-account-widget-user-name">
                {{ $plugin->shouldHaveTitle() ? $plugin->getTitle() : $name }}
            </p>
        </div>

        @if ($action)
            @if ($action->isVisible())
                {{ $action }}
            @endif
        @else
            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="fi-account-widget-logout-form"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    :icon="Heroicon::ArrowLeftEndOnRectangle"
                    :icon-alias="PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        @endif
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-widgets::widget>
