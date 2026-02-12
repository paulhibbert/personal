# whenFails for Validator

From the PR a simple illustration of a use case:

```php
// Before
public function someMethod($file)
{
    $validator = Validator::make(
        ['file' => $file],
        ['file' => 'required|image|dimensions:min_width=100,min_height=200']
    );

    if ($validator->fails()) {
        throw new InvalidArgumentException('Provided file is invalid');
    }
}
// After
public function someMethod($file)
{
    Validator::make(
        ['file' => $file],
        ['file' => 'required|image|dimensions:min_width=100,min_height=200']
    )->whenFails(function () {
        throw new InvalidArgumentException('Provided file is invalid');
    });
}
```

Obviously the most common use case for validation is part of the request cycle, in a FormRequest particularly, and fail/pass there is already handled. For most method parameters you'd want to aim for type safety, data object rather than arrays if possible, but where it does turn out to be necessary to validate in this way, having a fluent interface like this appears handy.

It is always worth looking at the actual change made though, not just the use case. Here is the new whenFails method from the PR, showing that its a wrapper for the `fails` method of the Validator class, which of course simply calls the `passes` method and return a NOT of the boolean returned from that method. In the example above the return does not use the returned validator, but its clearly possible to examine the message bag for example. It also does not pass a default callback which is provided in case the validator passes, so there is quite a bit more to this simple function than meets the eye from the initial usage example.

```php
public function whenFails(callable $callback, ?callable $default = null)
{
    if ($this->fails()) {
        return $callback($this) ?? $this;
    } elseif ($default) {
        return $default($this) ?? $this;
    }

    return $this;
}
```

There are already a number of options for applying a validator to a set of data.

```php
$validated = Validator::make(['url' => $url], [
    'url' => ['required', 'url'],
])->validate();
```

Underneath the hood the validate method calls the fails method and if it returns true throws a ValidationException which of course must be caught separately, otherwise returning the valid data from the input array.

There is an `after` method in the Validator class, which allows additional rules to be added to the Validator after its been constructed (it modifies the validator after property and returns the modified validator) and which rules are applied at the end of the passes method, so after the initial rules have been applied. Clearly, since whenFails and whenPasses are just calling `passes`, `after` needs to be applied to the validator before calling either of them.

```php
Validator::make(['url' => 'http://localhost'], ['url' => ['required', 'url']])
    ->after(function ($validator) {
        $validator->errors()->add('url', 'always fail'); 
    })
    ->whenFails(function ($validator) { 
        return $validator->errors();
    })
    ->(function ($validator) { ... });
```

Since the validator is passed to the callback it can be examined or altered and then returned. If no default callback is passed in `whenFails` then further chaining is possible on the passing validator, for example accessing the valid input data from the instance.

I wonder about passing the validator through a Pipeline.
