# Adding a card to the Laravel Pulse dashboard

This is an example of a pulse card that monitors third party providers by regularly calling an endpoint that returns application relevant information only, cannot affect the state of the application itself. It is a single card and so all the results are returned together, but lazily. I have not checked Pulse compatibility with Livewire V4 as yet, it may be possible to use islands to isolate each third party provider status without putting each one in their own card.

```php
use Illuminate\Support\Facades\View;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Throwable;

#[Lazy]
class ProvidersStatus extends Card
{
    public function render()
    {
        return View::make('livewire.providers-status', [
            'statuses' => $this->getProviderEndpointStatuses(),
            'runAt' => now()->toRfc850String(),
        ]);
    }

    public function getProviderEndpointStatuses()
    {
        $providers = [
            'ProviderA' => [
                'class' => ProviderAPI::class,
                'method' => 'getSomeInformation',
                'parameters' => CurrencyEnum::USD,
                'info' => 'Get Company balance',
            ],
            'Paypal' => [
                'class' => PaypalApi::class,
                'method' => 'getBalances',
                'parameters' => null,
                'info' => 'Get balances',
            ],
            'Google' => [
                'class' => PlaceIdReverseGeocoder::class,
                'method' => 'getPlaceLocation',
                'parameters' => ['ChIJx2E7b8UEdkgRtw6rLyLUl5w', false], // 10 Downing Street
                'info' => 'Get location details',
            ],
            'ProviderB' => [
                'class' => CurrencyConverterAPI::class,
                'method' => 'conversionRate',
                'parameters' => ['JPY', 'SGD'],
                'info' => 'Currency Conversion',
            ],
        ];
        $results = [];
        foreach ($providers as $providerName => $providerCheck) {
            $results[$providerName] = $this->getIntegrationApiMethodStatus(
                $providerCheck['class'],
                $providerCheck['method'],
                $providerCheck['parameters'],
                $providerCheck['info']
            );
        }
        return $results;
    }

    public function getIntegrationApiMethodStatus(string $className, string $method, mixed $parameters, string $info): array
    {
        try {
            $class = app($className);
            if (is_array($parameters)) {
                call_user_func_array([$class, $method], $parameters);
            } else {
                $class->$method($parameters);
            }
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
        return ['success' => true, 'message' => $info];
    }
}
```
