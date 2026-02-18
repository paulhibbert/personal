# Workflows

## Venture

Used [this](https://github.com/ksassnowski/venture) at Skyelarke, its a package that enables you to use Laravel jobs which implement the WorkflowableJob [interface](https://github.com/ksassnowski/venture/blob/master/src/WorkflowableJob.php) to construct pretty much any kind of workflow by creating dependencies between them.

![Example](/images/workflow.svg)

## Durable Workflow

- [Docs](https://durable-workflow.com/docs/introduction)

One of the building blocks of this [package](https://github.com/durable-workflow/workflow) is also a customised job class which implements `ShouldQueue` but this is a much more opinionated package with many more features than the Venture workflow.

[At first glance](https://durable-workflow.com/docs/how-it-works#example) its not obvious how you would elegantly go about constructing conditional branching workflows like the example from Venture, though clearly you could even in a linear flow such as the one illustrated implement conditional logic inside the activity much as with Laravel middleware which self-determines if its applied or not, not quite the same and certainly not as transparent as the Venture example.

![Example](/images/workflow.jpg)

That said there are also child workflows as a feature and so no doubt its possible to do a lot with that.

The focus here is on determinism and replay via idempotency, hence the durable tag. One comment I found a little confusing is referral to the potential use of [human in the loop steps](https://durable-workflow.com/docs/features/signals/) which seems on the surface to be incompatible with deterministic results, but I take this to mean that all results of external steps are recorded and so will not be executed when replayed but use the original response.

This idempotency constraint is very important to understand. It's obviously tremendously important in many contexts, but could make it unsuitable in others (example that springs to mind is getting an exchange rate - often you do indeed want the exchange rate at the time, but on other occasions I can imaging scenario where an up to date exchange rate would be wanted if retrying due to another step failing).

There are some very interesting [features](https://durable-workflow.com/docs/category/features) such as auto generated webhooks if use a Webhook attribute on an activity so that workflow steps can be triggered by external tools or integrations (though its interesting that workflows are also prunable which would remove those webhook routes, don't really like the use of incrementing ids in the route signature either, but minor point).

### Some technical notes on the durable workflow

- uses [promises](https://github.com/reactphp/promise), proper promises that can be passed around in the application. (Some of the contrived examples in the docs look like a Laravel pipeline). Points to [this gist](https://gist.github.com/domenic/3889970) from EmberJs that explains the difference between true promises and a callback aggregator (love the hate for JQuery there). Use of promises in this workflow package would bear more investigation.
  - also the [documentation](https://durable-workflow.com/docs/how-it-works/#promises) refers to promises in the context of [yield](https://www.php.net/manual/en/language.generators.syntax.php), stating

  >The yield keyword suspends execution until the promise is fulfilled or rejected. This allows the workflow to wait for an activity to complete before continuing execution.

  Also states that the execute function of a workflow is a generator, but it seems to me its only a generator if the yield keyword is actually used. To me it looks like the handler in the workflow class would fail dramatically if there is no yield in the execute implementation.

  The code below assumes that the coroutine object is a [generator](https://www.php.net/manual/en/class.generator.php) since the first thing it does, without checking if it is an instance of generator, is call a check on `coroutine->valid()`.

```php
$this->coroutine = $this->{'execute'}(...$this->resolveClassMethodDependencies(
    $this->arguments,
    $this,
    'execute'
));
```

- the only other dependency than the laravel framework itself is `spatie/laravel-model-states` and the package does enforce a kind of state machine with only certain allowed transitions between states.
- good example of a package which implements a usable mini-app in the workbench folder (rather than having to install the package in a separate app to get a feel for it).
- uses namespaced functions rather than global helpers :-)
- use of [pcntl_alarm](https://www.php.net/manual/en/function.pcntl-alarm.php) in the heartbeat function ?
- way it gets a snippet of the code around an exception, as the SplFileObject implements an Iterator :-)

```php
$file = new SplFileObject($exception->getFile());
$iterator = new LimitIterator($file, max(0, $exception->getLine() - 4), 7);
$snippet = array_slice(iterator_to_array($iterator), 0, 7)
```

There is a [sample-app](https://github.com/durable-workflow/sample-app) with examples of workflows started in artisan commands.

```php
$workflow = WorkflowStub::make(SimpleWorkflow::class);
$workflow->start();
while ($workflow->running());
$this->info($workflow->output());

// webhook example with an already stored webhook
Http::post("http://localhost/api/webhooks/signal/webhook-workflow/{$id}/ready");

$workflow = WorkflowStub::load($id);
while ($workflow->running());
$this->info($workflow->output());
```

The static make method stores a workflow class as a StoredWorkflow in the database, which can be loaded later into a new WorkflowStub (odd name) class. The start method loads the arguments in to the stored workflow arguments and then dispatches the workflow class (the one with shouldQueue) with those arguments (if any).
