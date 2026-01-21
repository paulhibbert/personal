<?php

use function Laravel\Folio\name;

name('topics.index');
?>

<x-layouts.app :title="__('Topics')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex flex-col gap-4">
            <livewire:load-article defer/>         
        </div>           
    </div>
</x-layouts.app>