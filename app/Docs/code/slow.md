# Pulse Slow Requests

In this application it was a report download endpoint that we really wanted to monitor, but the recorder of slow requests showed all of the calls to the endpoint indistinguisably. The route definition had a placeholder `type` to determine which report type was being downloaded, but the list of slow requests did not include the actual value submitted only this placeholder, so we were not able to see which report types were taking a long time to process.

First we have to extend the Pulse Recorder and override the method that is not working. In this case the method was rather long and only required a small change, its truncated in the code below, but this was the most efficient way to make the change and get the data required. I have added the override attribute here (it did not exist in PHP at the time)

```php
use Laravel\Pulse\Recorders\SlowRequests as RecordersSlowRequests;

class SlowRequests extends RecordersSlowRequests
{
    #[Override]
    public function record(Carbon $startedAt, Request $request, Response $response): void
    {
        ...

        /** this is the customisation to the standard recorder, to replace any listed placeholders with their real value */
        $placeHoldersToReplace = config('pulse.recorders.'.SlowRequests::class.'.replace', []);
        $pathForDisplay = $path;
        foreach ($placeHoldersToReplace as $placeHolder) {
            $parameter = Str::remove(['{', '}'], $placeHolder);
            if (Str::contains($path, $placeHolder) && $request->route()->hasParameter($parameter)) {
                $pathForDisplay = Str::replace($placeHolder, $request->route()->parameter($parameter), $pathForDisplay);
            }
        }

        $this->pulse->record(
            type: 'slow_request',
            key: json_encode([$request->method(), $pathForDisplay, $via], flags: JSON_THROW_ON_ERROR),
            value: $duration,
            timestamp: $startedAt,
        )->max()->count();

        ...
    }
}
```

In the pulse config, I replaced the original slow recorders class with the one above and added the array of placeholders to replace (in fact there was only one).

```php
    App\Recorders\SlowRequests::class => [
        'enabled' => env('PULSE_SLOW_REQUESTS_ENABLED', false),
        'sample_rate' => env('PULSE_SLOW_REQUESTS_SAMPLE_RATE', 1),
        'threshold' => env('PULSE_SLOW_REQUESTS_THRESHOLD', 2500),
        'ignore' => [
            '#^/'.env('PULSE_PATH', 'pulse').'$#', // Pulse dashboard...
            '#^/telescope#', // Telescope dashboard...
        ],
        'replace' => [
            '{type}',
        ],
    ],
```

It was also necessary to clone the entire Slow Request Card component simply in order to insert the DIY SlowRequests class above instead of the recorder that had the buggy feature (imo its probably a bug, but admittedly I did not raise it as such, the fix here is probably not the most elegant so also did not make a pull request either!).
