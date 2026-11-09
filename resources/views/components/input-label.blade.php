@props(['value'])

<label {{ $attributes->merge(['class' => 'label-lunaria']) }}>
    {{ $value ?? $slot }}
</label>