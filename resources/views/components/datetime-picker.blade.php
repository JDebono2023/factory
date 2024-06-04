@props([
    'options' => "{dateFormat:'Y-m-d', altFormat:'F j, Y ', altInput:true, minDate: new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), defaultDate: null, }",
])


<div wire:ignore>
    <input x-data="{ value: @entangle($attributes->wire('model')), instance: undefined }" x-init="() => {
        $watch('value', value => instance.setDate(value, true))
        instance = flatpickr($refs.input, {{ $options }});
    }" x-ref="input" type="text" data-input
        class="text-gray-900 text-sm   bg-white border-gray-700 shadow shadow-gray-400 rounded w-full"
        {{ $attributes }} />

</div>
