<?php

use function Laravel\Folio\name;

name('topics.index');
?>

<x-layouts.app.simple :title="__('Topics')">

    <x:slot:menu>
        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Topics')" class="grid">
                @foreach (App\Models\Topic::all() as $topic)
                    <flux:sidebar.group heading="{{ $topic->name }}" :expandable="true" :expanded="true">
                        @foreach (App\Models\Topic::getArticlesForTopic($topic->href) as $article)
                            <flux:sidebar.item icon="tag" href="#"
                                class="topic_link topic_{{ $topic->href }} article_{{ strtolower($article) }}">
                                {{ $article }}
                            </flux:sidebar.item>
                        @endforeach
                    </flux:sidebar.group>
                @endforeach
            </flux:sidebar.group>
        </flux:sidebar.nav>
    </x:slot>

    <flux:main>
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="flex flex-col gap-4">
                <livewire:load-article defer />
            </div>
        </div>
    </flux:main>

    <script>
        function init() {
            const topicLinks = document.querySelectorAll('.topic_link');
            topicLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    let articleName = link.classList[link.classList.length - 1].replace('article_', '')
                        .replaceAll('_', ' '); // Extract article name from class
                    let topic = link.classList[link.classList.length - 2].replace('topic_', '').replaceAll(
                        '_', ' '); // Extract topic name from class
                    Livewire.dispatch('topic-clicked', {
                        path: topic,
                        name: articleName
                    });
                });
            });
        };
        init();
    </script>
</x-layouts.app.simple>
