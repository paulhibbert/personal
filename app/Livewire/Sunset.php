<?php

namespace App\Livewire;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Uri;
use Livewire\Component;
use Throwable;

class Sunset extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchSunriseSunsetData() }}
        </div>
        HTML;
    }

    protected function fetchSunriseSunsetData(): string
    {
        try {
            $location = config('app.location');
            $uri = Uri::of('https://api.sunrise-sunset.org/json')
                ->withQuery([
                    'lat' => $location['latitude'],
                    'lng' => $location['longitude'],
                    'timezone' => 'UTC',
                    'date' => 'today',
                ]);
            $now = new CarbonImmutable;
            $sunriseSunset = Cache::remember('sunset', $now->tomorrow(), fn () => Http::get($uri)->json());
            $sunset = CarbonImmutable::parse($sunriseSunset['results']['sunset']);
            $sunsetDifference = (int) round(abs($now->diffInMinutes($sunset)), 0);
            $sunSetStatus = match (true) {
                $now->lessThan($sunset) => "Sunset will be in {$sunsetDifference} minutes at {$sunset->format('H:i')}",
                $now->greaterThan($sunset) => "Sunset was {$sunsetDifference} minutes ago at {$sunset->format('H:i')}",
                default => 'Sunset is approximately now',
            };
        } catch (Throwable $e) {
            logger()->error('Error fetching sunset data', [
                'exception' => $e,
            ]);
            $sunSetStatus = 'Unable to fetch sunset time';
        }

        return $sunSetStatus;
    }
}
