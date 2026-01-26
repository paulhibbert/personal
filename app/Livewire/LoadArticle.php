<?php

namespace App\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * This is a Livewire component that displays a random article from the 'docs' storage disk.
 * It uses the CommonMark library to convert Markdown content to HTML,
 * If a sidebar link is clicked, it loads the corresponding article instead.
 */
class LoadArticle extends Component
{
    public $articlePath = '';

    public function render()
    {
        return <<<'BLADE'
            <div>
                {!! $this->fetchArticle() !!}
            </div>
        BLADE;
    }

    public function placeholder()
    {
        return <<<'BLADE'
            <div>
                <p>Loading article...</p>
            </div>
        BLADE;
    }

    #[On('topic-clicked')]
    public function loadSelectedArticle(string $path, string $name)
    {
        $this->articlePath = "{$path}/{$name}.md";
        $this->render();
    }

    protected function fetchArticle(): string
    {
        $files = Storage::disk('docs')->allFiles();
        $config = [
            'external_link' => [
                'internal_hosts' => 'www.example.com', // TODO: change to your domain
                'open_in_new_window' => true,
                'html_class' => 'underline text-blue-600 hover:text-blue-800 visited:text-purple-600',
                'nofollow' => '',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
            'default_attributes' => [
                Heading::class => [
                    'class' => static function (Heading $node) {
                        if ($node->getLevel() === 1) {
                            return 'mb-4 text-2xl font-bold';
                        } else {
                            return 'mb-2 mt-2 text-xl font-semibold';
                        }
                    },
                ],
                ListBlock::class => [
                    'class' => 'mt-4',
                ],
            ],
        ];
        $attributesExtension = new AttributesExtension;
        $externalLinkExtension = new ExternalLinkExtension;
        $defaultAttributesExtension = new DefaultAttributesExtension;
        if (count($files) > 0) {
            $path = empty($this->articlePath) ? Arr::random($files) : $this->articlePath;
            $content = Storage::disk('docs')->get($path);
            $callable = fn () => 'Error loading article';

            return rescue(fn () => Str::markdown($content, $config, [$attributesExtension, $externalLinkExtension, $defaultAttributesExtension]), $callable, false);
        }

        return '';
    }
}
