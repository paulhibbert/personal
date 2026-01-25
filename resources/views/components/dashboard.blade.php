<?php

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Process;
use App\Models\Topic;

new class extends Component
{
    public Collection $documents;

    public function mount()
    {
        $this->documents = $this->documents();
    }

    public function lastCommitContent(): string
    {
        $result = Process::run('git diff HEAD~1..HEAD --compact-summary');
        if ($result->failed()) {
            return 'Unable to retrieve last commit content.';
        }   
        return $result->output();
    }

    public function documents(): Collection
    {
        $docs = [];
        foreach (Storage::disk('docs')->allFiles() as $file) {
            $docs[] = [
                'directory' => dirname($file),
                'filename' => basename($file),
            ];
        }
        return collect($docs)->groupBy('directory');
    }

    public function folioDemos(): array
    {
        $demosPath = 'views'.DIRECTORY_SEPARATOR.'folio'.DIRECTORY_SEPARATOR.'demos';
        $path = resource_path($demosPath);
        $demos = [];
        $dom = new \DOMDocument();
        foreach (scandir($path) as $file) {
            if (str_ends_with($file, '.blade.php') && $file !== 'index.blade.php') {
                $filePath = $path.DIRECTORY_SEPARATOR.$file;
                $content = file_get_contents($filePath);
                @$dom->loadHTML($content);
                $titleNodes = $dom->getElementsByTagName('title');
                $demos[] = $titleNodes->length > 0 ? $titleNodes->item(0)->textContent : 'Untitled';
            }
        }
        
        return $demos;
    }
};
?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h2 class="m-4 text-lg font-medium">Topics Overview</h2>
            <ul>
                @foreach(App\Models\Topic::all() as $topic)
                    <li class="ms-4">
                        <strong>{{ $topic->name }}</strong> ({{ $documents->get($topic->href)?->count() ?? 0 }} files)
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @island(defer:true)
                @placeholder
                    <span><x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /></span>
                @endplaceholder
                <span>
                    <h2 class="m-4 text-lg font-medium">Demos Overview</h2>
                    <ul>
                        @foreach($this->folioDemos() as $demo)
                            <li class="ms-4">
                                {{ $demo }}
                            </li>
                        @endforeach
                    </ul>
                </span>
            @endisland
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @island(defer:true)
                @placeholder
                    <span><x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /></span>
                @endplaceholder
                <span>
                    <h2 class="m-4 text-lg font-medium">Inline components</h2>
                    <ul class="text-sm">
                    <li class="ms-4 me-4"><livewire:sunset defer/></li>
                    <li class="ms-4 me-4"><livewire:weather defer/></li>
                    <li class="ms-4 me-4"><livewire:holidays defer/></li>
                    <li class="ms-4 me-4"><livewire:onthisday defer/></li>
                    <li class="ms-4 me-4"><livewire:current-carbon defer/></li>
                    </ul>
                </span>
            @endisland
        </div>
    </div>
    <div class="grid auto-rows-min gap-4 md:grid-cols-2">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                @island(defer:true)
                    @placeholder
                        <span><x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /></span>
                    @endplaceholder
                    <span>
                        <h2 class="m-4 text-lg font-medium">Last Commit Summary</h2>
                        <pre class="whitespace-pre-wrap p-4 text-sm">{{ $this->lastCommitContent() }}</pre>
                    </span>
                @endisland
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <span><x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /></span>
        </div>
    </div>
</div>
