<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Uri;

class FetchWeatherData
{
    protected string $url;

    protected int $cacheDurationMinutes = 10;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $station = config('app.location.weather_station_id');
        $today = now()->format('Y-m-d');
        $this->url = "https://wow.metoffice.gov.uk/observations/details/tableviewdata/{$station}/details/".$today;
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function fetch(): array
    {
        $uri = Uri::of($this->url)
            ->withQuery([
                'startAt' => '0',
                'hours' => '23:59:59',
                'fields' => 'DryBulbTemperature_Celsius',
            ]);

        return Cache::remember('weather', now()->addMinutes(10), fn () => Http::get($uri)->json());
    }
}
