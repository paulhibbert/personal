<?php

use function Laravel\Folio\name;

name('topics.index');
$randomTopic = \App\Models\Topic::inRandomOrder()->first();
?>

<x-layouts.app :title="__('Topics')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:heading size="lg">{{ 'Random Topic' }}</flux:heading>

        <div class="flex flex-col gap-4">
            @if ($randomTopic)
                <flux:heading size="md" class="mb-2">{{ $randomTopic->name }}</flux:heading>
                <flux:text>{{ 'To do, write a livewire component to load something about a random topic instead of doing it here. Wait for single file components in Livewire 4.' }}</flux:text>  
                <livewire:random-article lazy/>         
            @endif
        </div>           
    </div>
</x-layouts.app>