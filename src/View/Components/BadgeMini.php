<?php

namespace WireUi\View\Components;

use Illuminate\Support\Arr;
use WireUi\Traits\Components\HasSetupBadge;
use WireUi\Traits\Customization\{HasSetupColor, HasSetupIcon, HasSetupRounded, HasSetupSize, HasSetupVariant};
use WireUi\WireUi\Badge\{IconSizes, Rounders, Variants};
use WireUi\WireUi\BadgeMini\Sizes;

class BadgeMini extends BaseComponent
{
    use HasSetupIcon;
    use HasSetupSize;
    use HasSetupBadge;
    use HasSetupColor;
    use HasSetupRounded;
    use HasSetupVariant;

    public function __construct()
    {
        $this->setSizeResolve(Sizes::class);
        $this->setRoundedResolve(Rounders::class);
        $this->setVariantResolve(Variants::class);
        $this->setIconSizeResolve(IconSizes::class);
    }

    public function getRootClasses(): string
    {
        return Arr::toCssClasses([
            'outline-none inline-flex justify-center items-center group',
            $this->roundedClasses,
            $this->colorClasses,
            $this->sizeClasses,
        ]);
    }

    public function getIconClasses(): string
    {
        return Arr::toCssClasses([
            $this->iconClasses,
            'shrink-0',
        ]);
    }

    public function getView(): string
    {
        return 'wireui::components.badge-mini';
    }
}
