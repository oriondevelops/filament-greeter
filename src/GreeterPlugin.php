<?php

namespace Orion\FilamentGreeter;

use Closure;
use Filament\Actions\Action;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Support\Carbon;

class GreeterPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool | Closure $isHidden = false;

    protected bool | Closure $isVisible = true;

    protected ?int $sort = null;

    protected int | string | array $columnSpan = '1/2';

    protected bool | Closure | null $hasAvatar = null;

    protected bool | Closure | null $hasTitle = null;

    protected string $avatarSize = 'lg';

    protected string | null | Closure $avatarUrl = null;

    protected string | null | Closure $name = null;

    protected string | null | Closure $title = null;

    protected string | null | Closure $message = null;

    protected string | Action | Closure $action = 'logout';

    public function getId(): string
    {
        return 'filament-greeter';
    }

    public function hidden(bool | Closure $condition = true): static
    {
        $this->isHidden = $condition;

        return $this;
    }

    public function visible(bool | Closure $condition = true): static
    {
        $this->isVisible = $condition;

        return $this;
    }

    public function sort(int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    public function columnSpan(int | string | array $span = '1/2'): static
    {
        $this->columnSpan = $span;

        return $this;
    }

    public function avatar(string $size = 'lg', string | Closure | null $url = null, bool $enabled = true): static
    {
        $this->hasAvatar = $enabled;
        $this->avatarSize = $size;
        $this->avatarUrl = $url;

        return $this;
    }

    public function name(string | Closure $text): static
    {
        $this->name = $text;

        return $this;
    }

    public function title(string | Closure $text, bool $enabled = true): static
    {
        $this->hasTitle = $enabled;
        $this->title = $text;

        return $this;
    }

    public function message(string | Closure $text): static
    {
        $this->message = $text;

        return $this;
    }

    public function timeSensitive(int $morningStart = 6, int $afternoonStart = 12, int $eveningStart = 17, int $nightStart = 22): static
    {
        $hour = Carbon::now()->hour;

        // Cover the extreme case of a fantasy world where night start at 0 and morning start at 1
        $nightStart = $nightStart === 0 ? 24 : $nightStart;

        $key = match (true) {
            $hour >= $nightStart || $hour < $morningStart => 'night',
            $hour < $afternoonStart => 'morning',
            $hour < $eveningStart => 'afternoon',
            default => 'evening',
        };

        $this->message = fn () => __('greeter::widget.' . $key);

        return $this;
    }

    public function action(string | Action | Closure $action = 'logout'): static
    {
        $this->action = $action;

        return $this;
    }

    public function isHidden(): bool
    {
        if ($this->evaluate($this->isHidden)) {
            return true;
        }

        return ! $this->evaluate($this->isVisible);
    }

    public function isVisible(): bool
    {
        return ! $this->isHidden();
    }

    public function getSort(): int
    {
        return $this->sort ?? -3;
    }

    public function getColumnSpan(): int | string | array
    {
        return $this->evaluate($this->columnSpan);
    }

    public function shouldHaveAvatar(): bool
    {
        return $this->evaluate($this->hasAvatar) ?? true;
    }

    public function shouldHaveTitle(): bool
    {
        return $this->evaluate($this->hasTitle) ?? false;
    }

    public function getAvatarSize(): string
    {
        return $this->avatarSize;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->evaluate($this->avatarUrl);
    }

    public function getName(): ?string
    {
        return $this->evaluate($this->name);
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }

    public function getMessage(): ?string
    {
        return $this->evaluate($this->message);
    }

    public function getAction(): string | Action
    {
        return $this->evaluate($this->action);
    }

    public function register(Panel $panel): void
    {
        $panel->widgets([
            GreeterWidget::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
