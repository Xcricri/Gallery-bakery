@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-2 py-2.5 text-sm font-medium text-indigo-600 rounded-lg bg-indigo-50 dark:bg-gray-700 dark:text-white group transition-colors'
            : 'flex items-center px-2 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
