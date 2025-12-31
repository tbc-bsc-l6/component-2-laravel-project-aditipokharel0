@props([
    'variant' => 'primary', // primary, secondary, danger
    'type' => 'button'
])

@php
$base = "inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed";

$variants = [
    'primary' => "bg-gray-900 text-white hover:bg-gray-800 focus:ring-gray-900",
    'secondary' => "bg-white text-gray-900 border border-gray-300 hover:bg-gray-50 focus:ring-gray-400",
    'danger' => "bg-red-600 text-white hover:bg-red-700 focus:ring-red-600",
];

$cls = $base . " " . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $cls]) }}>
    {{ $slot }}
</button>
