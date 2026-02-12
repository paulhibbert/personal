# DIY API versioning, because why not?

In this article, I won't explain how the API functionality was handled across the different versions though I think it was pretty neat (the service version of the model was used to allow multiple api versions to map to the same code, for example a 2.1 and 2.2 would map to the same code, but a version 3 likely not), but focus on the end point which would return the status of an API version, whether it was still supported or not and whether it was deprecated.

First of all a model:

```php
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ?Carbon $supported_from
 * @property ?Carbon $deprecated_at
 * @property ?Carbon $supported_until
 *
 * @method static Builder Supported()
 */
class ApiVersion extends Model
{
    protected $fillable = [
        'api',
        'version',
        'service_version',
        'description',
        'supported_from',
        'deprecated_at',
        'supported_until',
    ];

    protected $casts = [
        'supported_from' => 'datetime:Y-m-d H:i:s',
        'deprecated_at' => 'datetime:Y-m-d H:i:s',
        'supported_until' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'id',
    ];

    public function isSupported(): bool
    {
        if (now()->lessThan($this->supported_from)) {
            return false;
        }

        return now()->lessThan($this->supported_until);
    }

    public function isDeprecated(): bool
    {
        if (empty($this->deprecated_at)) {
            return false;
        }
        return $this->isSupported() && now()->greaterThanOrEqualTo($this->deprecated_at);
    }

    public function scopeSupported(Builder $query): Builder
    {
        $now = now();
        return $query
            ->where('supported_from', '<=', $now)
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('supported_until')
                    ->orWhere('supported_until', '>=', $now);
            });
    }
}
```

And a Controller to provide a response:

```php

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiVersionResource;
use App\Models\ApiVersion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

/**
 * this controller will return the supported/deprecated status of a single api version or all versions
 * if none provided
 */
class ApiStatusController extends Controller
{
    protected string $api = 'your-api-name';

    public function status(?string $version = null): ResourceCollection|JsonResource|JsonResponse
    {
        if (empty($version)) {
            return ApiVersionResource::collection(ApiVersion::whereApi($this->api)->get());
        }

        try {
            return new ApiVersionResource(ApiVersion::whereApi($this->api)->whereVersion($version)->firstorFail());
        } catch (ModelNotFoundException $e) {
            return response()->json(['data' => [
                'api' => $this->api,
                'version' => $version,
                'supported' => 'Unknown Version',
            ]], Response::HTTP_NOT_FOUND);
        }
    }
}
```

And the JsonResource referred to in the controller:

```php
use App\Models\ApiVersion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiVersionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var ApiVersion $this */
        $supported = match (true) {
            ($this->isSupported() && empty($this->supported_until)) => 'Yes',
            $this->isSupported() => 'Until '.$this->supported_until->toDateString(),
            default => 'No'
        };

        $deprecated = match (true) {
            $this->isDeprecated() => 'Yes',
            ($this->isDeprecated() === false && ! empty($this->deprecated_at))
                => 'Deprecated from '.$this->deprecated_at->toDateString(),
            default => 'No'
        };

        return [
            'api' => $this->api,
            'version' => $this->version,
            'supported' => $supported,
            'deprecated' => $deprecated,
        ];
    }
}
```
