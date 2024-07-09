@props(['active', 'navigate'])

@php
    $classes = $active ?? false ? 'flex items-center p-2 text-white bg-orange-950 rounded-lg dark:text-orange-950 hover:bg-orange-300 dark:hover:bg-orange-950 group transition-all' : 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-orange-200 group transition-all';
@endphp

<a {{-- $navigate ?? true ? 'wire:navigate' : '' --}} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
