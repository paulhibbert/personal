<?php

namespace App\Livewire;

use App\Actions\FetchWeatherData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Livewire\Component;
use Throwable;

class WeatherSummary extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchLatestWeatherObservation() }}
        </div>
        HTML;
    }

    protected function doSomething()
    {
        $this->getId();
    }

    protected function fetchLatestWeatherObservation(): string
    {
        try {
            $weatherData = app(FetchWeatherData::class)->fetch();
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
