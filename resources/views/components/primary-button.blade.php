<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-lunaria']) }}>
    {{ $slot }}
</button>