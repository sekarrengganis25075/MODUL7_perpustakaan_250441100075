<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-lunaria btn-lunaria-danger']) }}>
    {{ $slot }}
</button>