<?php

use function Laravel\Folio\name;

name('topics.index');
?>

<x-layouts.app :title="__('Topics')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:heading size="lg">{{ 'Random Article' }}</flux:heading>

        <div class="flex flex-col gap-4">
            <livewire:random-article defer/>         
        </div>           
    </div>
</x-layouts.app>