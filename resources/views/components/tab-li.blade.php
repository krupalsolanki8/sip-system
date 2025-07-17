@props(['active'])

@php
    $classes =
        'tab-li flex text-sm leading-6 font-semibold pt-3 pb-2.5 border-b-2 -mb-px ' .
        ($active ?? false
            ? 'text-blue-700 border-current'
            : 'text-slate-900 border-transparent hover:border-slate-300 dark:text-slate-200 dark:hover:border-slate-700');
@endphp

<li>
    <h2>
        <a {{ $attributes->merge(['class' => $classes]) }}>
            {{ $slot }}
        </a>
    </h2>
</li>
