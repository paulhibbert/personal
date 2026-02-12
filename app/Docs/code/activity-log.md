---
title: Extending the Spatie Activity Log package
permalink: /articles/activity-log
---

Out of the box the package enables events to be recorded as they happen to a model and its very easy to use, however in this case most of these models were children of an overarching entity and it was important to be able to easily aggregate this data (noting that as with many event log cases the current state of those models and their relations may have changed since the event so unless the relation is recorded in the activity log table when the event occurs it may not be possible to re-associate it with a parent).

The easy part of course is adding a migration to insert new fields into the table which is created by the package. In this case was a `morphTo` relation called related.

The model class looked something like this:

```php
use App\Contracts\Activity\ActivityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity implements ActivityInterface
{
    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeRelatedTo(Builder $query, Model $related): Builder
    {
        return $query
            ->where('related_type', $related->getMorphClass())
            ->where('related_id', $related->getKey());
    }
}
```

As a well-designed package built with extensibility in mind the config file allows the developer to override the model class using the `activity_model` config key.

Its also necessary to extend the package's interface for the base model with one's own:

```php
namespace App\Contracts\Activity;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Contracts\Activity;

interface ActivityInterface extends Activity
{
    public function related(): MorphTo;
}
```

And finally we have to override the main ActivityLogger class so that we will fill in the related fields when creating the log of an event.

```php
use App\Contracts\Activity\ActivityInterface as ActivityContract;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\ActivityLogger as SpatieActivityLogger;

class ActivityLogger extends SpatieActivityLogger
{
    public function relatedTo(?Model $model): static
    {
        $this->getActivity()->related()->associate($model);
        return $this;
    }

    #[Override]
    protected function getActivity(): ActivityContract
    {
        if (! $this->activity instanceof ActivityContract) {
            $this->activity = new ActivityLog;
            $this
                ->useLog($this->defaultLogName)
                ->withProperties([])
                ->causedBy($this->causerResolver->resolve());

            $this->activity->batch_uuid = $this->batch->getUuid();
        }
        return $this->activity;
    }
}
```

The override looks almost identical to the overridden method, but crucially it returns an instance of our model not the base model from the package. And of course it adds the static function to associate the model with the related model using the additional method on our contract which is not present in the original interface.

The package provides a helper function which returns its own ActivityLogger class with a fluent interface which is handy.

```php
activity()
   ->performedOn($anEloquentModel)
   ->causedBy($user)
   ->withProperties(['customProperty' => 'customValue'])
   ->log('Look, I logged something');
```

But it does not have our extra method, but we can create our own helper making sure to return an instance of our own logger which has all of the original methods plus our new one. So in our own helpers file we use a different function name of course

```php
if (! function_exists('our_activity')) {
    function our_activity(?string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog.default_log_name');
        return app(ActivityLogger::class)
            ->useLog($logName ?? $defaultLogName);
    }
}
```

```php
activity()
   ->performedOn($anEloquentModel)
   ->causedBy($user)
   ->relatedTo($aParentModel)
   ->withProperties(['customProperty' => 'customValue'])
   ->log('Look, I logged something');
```

Note that its added public function on the ActivityLogger class which takes a model as its input which is chained in this fluent api here and not the model scope which takes a Builder query and the related model as its parameters.
