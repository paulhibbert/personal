<?php

namespace App\Livewire;

use Throwable;
use Livewire\Component;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Uri;
use Illuminate\Support\Facades\Http;

class Weather extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchLatestWeatherObservation() }}
        </div>
        HTML;
    }

    protected function fetchLatestWeatherObservation(): string
    {
        try {
            $today = now()->format('Y-m-d');
            $uri = Uri::of('https://wow.metoffice.gov.uk/observations/details/tableviewdata/946846001/details/'.$today)
                ->withQuery([
                    'startAt' => '0',
                    'hours' => '23:59:59',
                    'fields' => 'DryBulbTemperature_Celsius',
                ]);
            $weatherData = Cache::remember('weather', now()->addMinutes(10), fn() => Http::get($uri)->json());
            $latestObservation = Arr::first($weatherData['Observations']);
            $reportedAt = CarbonImmutable::parse($latestObservation['localReportEndDateTime']);
            $temperature = $latestObservation['dryBulbTemperature_Celsius'];
            $pressureMeasurement = (int) $latestObservation['airPressure_Hectopascal'] ?? 0;
            $pressure = match (true) {
                $pressureMeasurement >= 1020 => ' Pressure was high at '.$pressureMeasurement.' hPa.',
                $pressureMeasurement <= 1010 => ' Pressure was low at '.$pressureMeasurement.' hPa.',
                default => '',
            };
            return "As of {$reportedAt->format('H:i')}, the temperature was {$temperature} °C.".$pressure;
        } catch (Throwable $e) {
            logger()->error('Error fetching latest weather observation', [
                'exception' => $e,
            ]);
            return 'Unable to fetch weather data';
        }
    }
}
