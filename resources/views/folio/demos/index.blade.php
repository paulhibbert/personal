
<?php

use function Laravel\Folio\name;

name('demos.index');
?>

<x-layouts.app.simple title="Demos">

    <x:slot:menu>
        <flux:sidebar.group :heading="__('Pre 2020')" class="grid">
            <flux:sidebar.item icon="tag" href="/demos/calc" target="demoFrame">
                {{ 'Vue2 Calc' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/todo" target="demoFrame">
                {{ 'Vue2 Todo' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/sudoku" target="demoFrame">
                {{ 'Vue2 Sudoku' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/bees" target="demoFrame">
                {{ 'Bees' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/cv" target="demoFrame">
                {{ 'CV' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/randomiser" target="demoFrame">
                {{ 'Randomiser' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/canvas" target="demoFrame">
                {{ 'Canvas Animation' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="/demos/drag" target="demoFrame">
                {{ 'Drag and Drop puzzle' }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" href="https://genealogical-notes.blogspot.com/?view=magazine" target="demoFrame" rel="noopener noreferrer">
                {{ 'Genealogy blog 2014' }}
            </flux:sidebar.item>
        </flux:sidebar.group>
        <flux:sidebar.group :heading="__('Livewire')" class="grid">
            <flux:sidebar.item icon="tag" href="/demos/weather-demo" target="demoFrame">
                {{ 'Weather Demo' }}
            </flux:sidebar.item>
        </flux:sidebar.group>
        <flux:sidebar.group :heading="__('Modern Vue')" class="grid">
            <flux:sidebar.item icon="tag" href="/demos/sudoku-demo" target="demoFrame">
                {{ 'Sudoku Demo' }}
            </flux:sidebar.item>
        </flux:sidebar.group>
    </x:slot>

    <flux:main>
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <iframe name="demoFrame" style="height: inherit;"></iframe>               
        </div>
    </flux:main>

</x-layouts.app.simple>
