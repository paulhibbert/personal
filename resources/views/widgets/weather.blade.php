<?php

use Livewire\Component;
use App\Actions\FetchWeatherData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

new class extends Component
{
    public array $temperatures = [];

    public function mount()
    {
        $this->temperatures = $this->fetchTemperatures();
    }

    public function fetchTemperatures(): array
    {
        try {
            $weatherData = app(FetchWeatherData::class)->fetch();
            $temps = collect($weatherData['Observations'])->map(function ($observation) {
                $observationTime = CarbonImmutable::parse($observation['localReportEndDateTime']);
                return ['observation_time' => $observationTime->format('H:i:s'), 'temperature' => $observation['dryBulbTemperature_Celsius']];
            });

            return $temps->sortBy('observation_time')->values()->all();
        } catch (\Throwable $e) {
            Log::error('Error fetching weather data: ' . $e->getMessage());
            return [];
        }
    }

};
?>

<div>
    <canvas id="barChartCanvas"></canvas>
    <div id="weatherData" class="hidden">{{ json_encode($this->temperatures) }}</div>
</div


@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
@endassets

<script>
    const ctx = document.getElementById('barChartCanvas').getContext('2d');
    const temperatures = [];
    const labels = [];

    const weatherChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperatures Today (°C)',
                data: temperatures,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const weatherDataElement = document.getElementById('weatherData');
    const weatherData = JSON.parse(weatherDataElement.textContent);
    if (weatherData.length === 0) {
        weatherDataElement.innerText = 'Unable to load weather data';
        weatherDataElement.classList.remove('hidden');
    }
    for (const [key, data] of Object.entries(weatherData)) {
        weatherChart.data.labels.push(data.observation_time);
        weatherChart.data.datasets[0].data.push(data.temperature);
    }
    weatherChart.update();
</script>