<div>
    <h1>Radio Test</h1>

    <span dusk="radio">@json($radio)</span>

    // test it_should_render_with_label_and_change_value
    <x-radio id="laravel"  value="Laravel"  label="Laravel"  wire:model.live="radio" />
    <x-radio id="livewire" value="Livewire" label="Livewire" wire:model.live="radio" />

    // test it_should_dont_see_the_input_error_message
    <x-input wire:model.live="errorless" label="Test error less" :errorless="true" />

    <button wire:click="validateRadio" dusk="validate">validate</button>
</div>
