@php
    $user = filament()->auth()->user();
    $plugin = filament('filament-greeter');
    $name = $plugin->getName();
    $title = $plugin->getTitle();
    $message = $plugin->getMessage();
    $avatarSize = $plugin->getAvatarSize();
    $avatarUrl = $plugin->getAvatarUrl();
    $action = $plugin->getAction();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            @if($plugin->shouldHaveAvatar())
                <x-filament-panels::avatar.user
                    :src="$avatarUrl ?? filament()->getUserAvatarUrl($user)"
                    :size="$avatarSize"
                    :user="$user"/>
            @endif

            <div class="flex-1">
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    {{ $message ?? __('greeter::widget.message') }}
                    @if($plugin->shouldHaveTitle())
                        {{ $name ?? filament()->getUserName($user) }}
                    @endif
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if($plugin->shouldHaveTitle())
                        {{ $title }}
                    @else
                        {{ $name ?? filament()->getUserName($user) }}
                    @endif
                </p>
            </div>

            @if($action instanceof \Filament\Actions\Action)
                @if ($action->isVisible())
                    {{ $action }}
                @endif
            @else
                <form
                    action="{{ filament()->getLogoutUrl() }}"
                    method="post"
                    class="my-auto"
                >
                    @csrf

                    <x-filament::button
                        color="gray"
                        icon="heroicon-m-arrow-left-on-rectangle"
                        icon-alias="panels::widgets.account.logout-button"
                        labeled-from="sm"
                        tag="button"
                        type="submit"
                    >
                        {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                    </x-filament::button>
                </form>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
