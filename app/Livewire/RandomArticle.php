<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;

/**
 * This is a Livewire component that displays a random article from the 'docs' storage disk.
 * It uses the CommonMark library to convert Markdown content to HTML,
 * Ideally we want to be able to click on one of the menu items in the sidebar and load the indicated article.
 */
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

    public function placeholder()
    {
        return <<<'BLADE'
            <div>
                <p>Loading article...</p>
            </div>
        BLADE;
    }

    protected function fetchRandomArticle(): string
    {
        $files = Storage::disk('docs')->allFiles();
        $config = [
            'external_link' => [
                'internal_hosts' => 'www.example.com', // TODO: change to your domain
                'open_in_new_window' => true,
                'html_class' => 'external-link',
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
        $attributesExtension = new AttributesExtension();
        $externalLinkExtension = new ExternalLinkExtension();
        $defaultAttributesExtension = new DefaultAttributesExtension();
        if (count($files) > 0) {
            $path = Arr::random($files);
            $content = Storage::disk('docs')->get($path);
            return Str::markdown($content, $config, [$attributesExtension, $externalLinkExtension, $defaultAttributesExtension]);
        }
        return '';
    }
}
