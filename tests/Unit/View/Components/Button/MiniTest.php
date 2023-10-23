<?php

namespace Tests\Unit\View\Components\Button;

use WireUi\Enum\Packs;
use WireUi\View\Components\Button\Mini;
use WireUi\WireUi\Button\Color\Outline;
use WireUi\WireUi\Button\IconSize;
use WireUi\WireUi\Button\Size\Mini as SizeMini;
use WireUi\WireUi\Rounded;

beforeEach(function () {
    $this->component = (new Mini())->withName('mini-button');
});

test('it should have array properties', function () {
    $packs = $this->invokeProperty($this->component, 'packs');

    expect($packs)->toBe(['icon-size']);

    $props = $this->invokeProperty($this->component, 'props');

    expect($props)->toBe([
        'icon'              => null,
        'label'             => null,
        'wire-load-enabled' => false,
    ]);
});

test('it should have properties in component', function () {
    $this->runWireUiComponent($this->component);

    expect($this->component)->toHaveProperties([
        'icon',
        'size',
        'color',
        'label',
        'rounded',
        'squared',
        'variant',
        'sizeClasses',
        'colorClasses',
        'roundedClasses',
        'wireLoadEnabled',
    ]);

    expect($this->component->wireLoadEnabled)->toBeFalse();
});

test('it should not have properties in component', function () {
    expect($this->component)->not->toHaveProperties([
        'icon',
        'label',
        'wireLoadEnabled',
    ]);
});

test('it should render button like link', function () {
    $this->setAttributes($this->component, [
        'href' => $href = fake()->url(),
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->tag)->toBe('a');

    expect('<x-mini-button :$href />')->render(compact('href'))->toContain($href);
});

test('it should set specific label in component', function () {
    $this->setAttributes($this->component, [
        'label' => $label = fake()->word(),
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->label)->toBe($label);

    expect('<x-mini-button :$label />')->render(compact('label'))->toContain($label);
});

test('it should set icon and right icon in component with lg size', function () {
    $this->setAttributes($this->component, [
        'size' => $size = Packs\Size::LG,
        'icon' => $icon = $this->getRandomIcon(),
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->icon)->toBe($icon);

    expect($this->component->size)->toBe($size);

    expect($this->component->iconSize)->toBe($size);

    expect($this->component->sizeClasses)->toBe($sizeClasses = (new SizeMini())->get($size));

    expect($this->component->iconSizeClasses)->toBe($iconSizeClasses = (new IconSize())->get($size));

    expect('<x-mini-button :$size :$icon />')
        ->render(compact('size', 'icon'))
        ->toContain($sizeClasses)
        ->toContain(render('<x-icon :name="$icon" @class([$iconSizeClasses, "shrink-0"]) />', compact('icon', 'iconSizeClasses')));
});

test('it should set specific color in component with variant outline', function () {
    $this->setAttributes($this->component, [
        'color'   => Packs\Color::INFO,
        'variant' => Packs\Variant::OUTLINE,
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->color)->toBe($color = Packs\Color::INFO);

    expect($this->component->variant)->toBe($variant = Packs\Variant::OUTLINE);

    $class = (new Outline())->get(Packs\Color::INFO);

    expect($this->component->colorClasses)->toBe($class = $this->serializeColorClasses($class));

    expect('<x-mini-button :$color :$variant />')
        ->render(compact('color', 'variant'))
        ->toContain(...collect($class)->flatten()->toArray());
});

test('it should set rounded full in component', function () {
    $this->setAttributes($this->component, [
        'rounded' => true,
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->rounded)->toBeTrue();

    expect($this->component->squared)->toBeFalse();

    expect($this->component->roundedClasses)->toBe($class = (new Rounded())->get(Packs\Rounded::FULL));

    expect('<x-mini-button rounded />')->render()->toContain($class);
});

test('it should set squared in component', function () {
    $this->setAttributes($this->component, [
        'squared' => true,
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->squared)->toBeTrue();

    expect($this->component->rounded)->toBeFalse();

    expect($this->component->roundedClasses)->toBe($class = (new Rounded())->get(Packs\Rounded::NONE));

    expect('<x-mini-button squared />')->render()->toContain($class);
});

test('it should custom rounded in component', function () {
    $this->setAttributes($this->component, [
        'rounded' => $class = 'rounded-[40px]',
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->squared)->toBeFalse();

    expect($this->component->rounded)->toBe($class);

    expect($this->component->roundedClasses)->toBe($class);

    expect('<x-mini-button rounded="rounded-[40px]" />')->render()->toContain($class);
});
