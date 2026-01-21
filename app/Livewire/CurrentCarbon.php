<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrentCarbon extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchCurrentCarbonIntensity() }}
        </div>
        HTML;
    }

    protected function fetchCurrentCarbonIntensity(): string
    {
        try {
            $intensity = Cache::remember('current_carbon_intensity', now()->addMinutes(15), function () {
                return Http::get('https://api.carbonintensity.org.uk/intensity')->json()['data'][0]['intensity'];
            });
            $actual = $intensity['actual'] ?? 'N/A';
            return "Current carbon intensity of GB energy system is {$intensity['index']} at {$actual} gCO2/kWh.";
        } catch (\Throwable $e) {
            logger()->error('Error fetching current carbon intensity data', [
                'exception' => $e,
            ]);
            return 'Unable to fetch current carbon intensity data';
        }
    }
}
