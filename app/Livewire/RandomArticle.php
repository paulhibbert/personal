<?php

namespace App\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class RandomArticle extends Component
{
public function render()
{
    return <<<'BLADE'
        <div>
            {!! $this->fetchRandomArticle() !!}
        </div>
    BLADE;
}

    protected function fetchRandomArticle(): string
    {
        $files = Storage::disk('docs')->allFiles();
        if (count($files) > 0) {
            $path = Arr::random($files);
            $content = Storage::disk('docs')->get($path);
            return Str::markdown($content);
        }
        return '';
    }
}
