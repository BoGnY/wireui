<?php

namespace WireUi\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\{Collection, ViewErrorBag};
use Illuminate\View\Component;

class Errors extends Component
{
    public function __construct(
        public ?string $title = null,
        public mixed $only = [],
        public ?string $icon = null,
        public ?bool $undivided = null,
        public ?bool $iconless = false,
    ) {
        $this->title ??= trans('wireui::messages.errors.title');

        $this->initOnly();
    }

    protected function initOnly(): void
    {
        if (is_string($this->only)) {
            $this->only = str($this->only)->explode('|');

            $this->only->transform(fn (string $name) => trim($name));
        }

        $this->only = collect($this->only);
    }

    public function count(ViewErrorBag $errors): int
    {
        return $this->getErrorMessages($errors)->count();
    }

    public function getErrorMessages(ViewErrorBag $errors): Collection
    {
        $messages = $errors->getMessages();

        return $this->only->isNotEmpty() ? collect($messages)->only($this->only) : collect($messages);
    }

    public function render(): View
    {
        return view('wireui::components.errors');
    }
}
