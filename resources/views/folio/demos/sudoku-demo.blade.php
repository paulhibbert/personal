<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>Sudoku in Vue Component</title>
    </head>
    @php
        $data = app(App\Actions\FetchSudoku::class)->fetch();
    @endphp

    <body class="min-h-screen bg-white dark:bg-zinc-800 text-2xl text-zinc-900 dark:text-zinc-100">
        <span class="hidden" id="sudoku-data" data-props='@json($data)'></span>
        <div id="vue-sudoku" class="p-4 xl:p-16"></div>

        @vite('resources/js/new-sudoku.js')

    </body>
</html>
