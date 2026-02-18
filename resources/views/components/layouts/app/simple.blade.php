<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            table {
                border-collapse: collapse;
                margin-bottom: 1em;
                } 
                table th, table td { 
                    border: 1px solid #ddd; 
                    padding: 0.5em;
            }
            pre {
                margin-top: 1em;
                margin-bottom: 1em;
                background: CanvasText;
                border-radius: 0.5em;
                padding: 0.5em;
                color: Canvas;
            }
            li {
                list-style-type: disc;
                margin-bottom: 0.5em;
            }
            .hl-keyword {
                color: springgreen;
            }

            .hl-property {
                color: #a47af2;
            }

            .hl-attribute {
                font-style: italic;
            }

            .hl-injection {
                color: #41f941;
            }

            .hl-type {
                color: #EA4334;
            }

            .hl-generic {
                color: #9d3af6;
            }

            .hl-value {
                color: #1e6de3;
            }

            .hl-literal .hl-number {
                color: #1254b8;
            }

            .hl-variable {
                color: #ff6000;
            }

            .hl-comment {
                color: #6e7781;
            }

            .hl-blur {
                filter: blur(2px);
            }

            .hl-strong {
                font-weight: bold;
            }

            .hl-em {
                font-style: italic;
            }

        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

            <nav class="flex flex-col overflow-visible min-h-auto data-flux-sidebar-nav">
                {{ $menu }}
            </nav>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Main menu')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ 'Home' }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cube" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ 'Dashboard' }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="book-open" :href="route('topics.index')" :current="request()->routeIs('topics.index')" wire:navigate>
                        {{ 'Topics' }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cog-6-tooth" :href="route('demos.index')" :current="request()->routeIs('demos.index')" wire:navigate>
                        {{ 'Demos' }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
            <flux:spacer />
        </flux:sidebar>


        {{ $slot }}

        @fluxScripts

    </body>
</html>
