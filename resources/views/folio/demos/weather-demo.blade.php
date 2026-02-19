<x-layouts.app.plain title="Weather Demo">

    <x:slot:heading>
        <livewire:weather-summary defer/>
    </x:slot>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <livewire:widgets::weather defer/>              
    </div>

</x-layouts.app.simple>
