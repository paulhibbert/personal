<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\ValueObjects\YearPrefixedString;

class OnThisDay extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchHeadline() }}
        </div>
        HTML;
    }

    protected function fetchHeadline(): string
    {
        $now = new CarbonImmutable();
        $month = strtolower($now->format('F'));
        $dayOfMonth = $now->format('j');
        $url = "http://news.bbc.co.uk/onthisday/low/dates/stories/{$month}/{$dayOfMonth}/default.stm";
        try {
            $onThisDayContent = Cache::remember('onthisday', $now->tomorrow(), fn() => file_get_contents($url));
            $dom = new \DOMDocument();
            @$dom->loadHTML($onThisDayContent);
            $links  = $dom->getElementsByTagName('a');
            $usableLinks = [];
            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                $deconstructedValue = YearPrefixedString::tryFrom($link->nodeValue);
                if (
                    ! is_null($deconstructedValue) &&
                    str_contains($href, "/stories/{$month}/{$dayOfMonth}/")
                ) {
                    $usableLinks[$deconstructedValue->year()] = $deconstructedValue->raw();
                }
            }
            $randomSelectedHeadline = Arr::random($usableLinks);
            $today = $now->format('jS F');
            return "On this day, $today in {$randomSelectedHeadline}";
        } catch (\Throwable $e) {
            Log::error('Error fetching On This Day data', [
                'exception' => $e,
            ]);
            return 'Unable to fetch On This Day data';
        }   
    }
}
