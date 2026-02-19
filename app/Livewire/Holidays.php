<?php

namespace App\Livewire;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Holidays extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchNextHoliday() }}
        </div>
        HTML;
    }

    protected function fetchNextHoliday(): string
    {
        try {
            $holidays = Cache::remember('holidays', now()->addDays(7), function () {
                return Http::connectTimeout(3)->timeout(3)->get('https://www.gov.uk/bank-holidays.json')->json()['england-and-wales']['events'];
            });
            $nextHoliday = collect($holidays)->first(fn ($event) => strtotime($event['date']) > now()->timestamp);
            if ($nextHoliday) {
                $holidayDate = CarbonImmutable::parse($nextHoliday['date']);
                $daysUntil = (int) now()->diffInDays($holidayDate);

                return "The next public holiday is {$nextHoliday['title']} on {$holidayDate->format('d M Y')} (in {$daysUntil} days)";
            }
        } catch (\Throwable $e) {
            logger()->error('Error fetching holidays data', [
                'exception' => $e,
            ]);

            return 'Unable to fetch holidays data';
        }

        return '';
    }
}
