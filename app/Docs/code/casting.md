# Casting a JSON column

There are plenty of options. The road of least resistance is to cast as an array, though I have also often used the AsCollection class, as always the [docs](https://laravel.com/docs/master/eloquent-mutators#array-object-and-collection-casting) are very useful here.

On some occasions though you want to treat the JSON column as a single object and the notes here refer to my first excursion on this road. I recently revisited it and I was able to implement again in a different context in a slightly simpler way, but I don't have access to that code, so here is the original.

In this case I was storing geocoding data against an address, retrieved from the Google API, using the [Spatie](https://github.com/spatie/geocoder) package, with a few bells and whistles added in of course. I won't provide every detail of the implementation, but hopefully there is enough to illustrate the approach.

Here a cut down version of the model with fillable and cast attributes.

```php

use App\Casts\GeocodeCast;
use App\Data\Address\GeocodeDTO;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $line_1
 * @property ?string $line_2
 * @property string $city
 * @property string $postcode
 * @property ?GeocodeDTO $geocode_data
 */
class Address extends Model
{
    protected $fillable = [
        'line_1',
        'line_2',
        'city',
        'postcode',
        'geocode_data->lat',
        'geocode_data->lng',
        'geocode_data->placeId',
        'geocode_data->formattedAddress',
        'geocode_data->accuracy',
        'geocode_data->viewPortDiagonalMeters',
    ];

    protected $casts = [
        'geocode_data' => GeocodeCast::class,
    ];

}
```

By specifying each of the JSON keys as fillable these become assignable in updates just like any other model attribute. The eagle eyed may spot something odd about the accuracy attribute, it is in fact a Spatie remapping of the `$result->geometry->location_type` from the result. Best is 'ROOFTOP', other possible values are 'RANGE_INTERPOLATED', 'GEOMETRIC_CENTER' and 'APPROXIMATE'. Other than the rooftop result this does not tell us much. But the size of the recommended viewport to view the location does tell us a lot about how accurate the result is. More of this anon.

In the original application we were also using a now rather old version of the Spatie [Laravel Data package](https://github.com/spatie/laravel-data) (not for any particularly good reason imho), so the Data Object for the GeoCode data extends their base object. It has two static methods, one to create itself from the response delivered from the API and the other to instantiate itself from the Model (this is vital of course for the casting part of this story). It also embeds another class which we are using to get the size of the viewport in meters (the orginal which is credited names its function incorrectly as if it was returning kilometers).

```php
use Spatie\LaravelData\Data;

class GeocodeDTO extends Data
{
    public function __construct(
        public ?float $lat = null,
        public ?float $lng = null,
        public ?string $placeId = '',
        public ?string $accuracy = '',
        public ?int $viewPortDiagonalMeters = 0,
        public ?string $formattedAddress = '',
    ) {
    }

    public static function fromModelAttribute(array $attribute): self|null
    {
        if (empty($attribute['lat'] || empty($attribute['lng']) || empty($attribute['placeId']))) {
            return null;
        }

        return new self(
            lat: $attribute['lat'],
            lng: $attribute['lng'],
            placeId: $attribute['placeId'] ?? '',
            accuracy: $attribute['accuracy'] ?? '',
            viewPortDiagonalMeters: $attribute['viewPortDiagonalMeters'] ?? 0,
            formattedAddress: $attribute['formattedAddress'] ?? ''
        );
    }

    public static function fromGeocodeResponse(array $response): self
    {
        if (empty($response['lat'])) {
            throw new Exception(__('No geocode match found for this address'));
        }

        /**
         * Because accuracy for a geocode match on a single postcode or a whole country are both "APPROXIMATE"
         * this is NOT useful for determining actual accuracy, we can use the viewport size as a more useful
         * proxy.
         */
        try {
            $ne = new POI($response['viewport']->northeast->lat, $response['viewport']->northeast->lng);
            $sw = new POI($response['viewport']->southwest->lat, $response['viewport']->southwest->lng);
            $distance = $ne->getDistanceInMetersTo($sw);
        } catch (Throwable) {
            throw new Exception(__('Unable to verify accuracy of geocode match'));
        }

        return new self(
            lat: $response['lat'],
            lng: $response['lng'],
            placeId: $response['place_id'],
            accuracy: $response['accuracy'],
            viewPortDiagonalMeters: (int) round($distance, 2, PHP_ROUND_HALF_DOWN),
            formattedAddress: $response['formatted_address']
        );
    }

    public function getArrayCopy(): array
    {
        return $this->toArray();
    }
}

/**
 * From https://rosettacode.org/wiki/Haversine_formula#PHP
 * with correction to return meters not kilometers despite the name of the function
 */
class POI
{
    private $latitude;
    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = deg2rad($latitude);
        $this->longitude = deg2rad($longitude);
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getDistanceInMetersTo(POI $other)
    {
        $radiusOfEarth = 6371; // Earth's radius in kilometers.

        $diffLatitude = $other->getLatitude() - $this->latitude;
        $diffLongitude = $other->getLongitude() - $this->longitude;

        $a = sin($diffLatitude / 2) ** 2 +
             cos($this->latitude) *
             cos($other->getLatitude()) *
             sin($diffLongitude / 2) ** 2;

        $c = 2 * asin(sqrt($a));
        $distance = $radiusOfEarth * $c;

        return $distance * 1000;
    }
}
```

Finally we can implement the casting of the JSON column to this DTO. It is the anonymous class which implements the CastsAttributes contract which does the getting and setting. The column is nullable so the cast will also return null.

```php
use App\Data\Address\GeocodeDTO;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Casts\Json;

class GeocodeCast implements Castable
{
    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes)
            {
                if (! isset($attributes[$key])) {
                    return;
                }
                $data = Json::decode($attributes[$key]);
                return is_array($data) ? GeocodeDTO::fromModelAttribute($data) : null;
            }

            public function set($model, $key, $value, $attributes)
            {
                return [$key => Json::encode($value)];
            }

            public function serialize($model, string $key, $value, array $attributes)
            {
                return $value->getArrayCopy();
            }
        };
    }
}
```
