@props(['title'])

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $title ?? '' }}
    </h2>
</x-slot>
