# Precognitive validation

One of the joys of using Inertia is using what Laravel calls precognition. I won't repeat the [documentation](https://laravel.com/docs/master/precognition) here, it used to require separate installation but its now built into Inertia, and one of the things it enables is to implement validation in one place, on the backend.

Here is one example (details a little vague from memory). There are two options which are mutually incompatible, and whatever html markup is used which in theory prevents more than one option being selected, we want to validate on the backend (in this case it was precognitively).

We need a FormRequest along these lines, i.e. its just a standard FormRequest and Inertia middleware handles delivering the error message into the component props. Nice.

```php
use Illuminate\Foundation\Http\FormRequest;

class ServicesRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'has_stipends' => ['accepted_if:has_expenses,false', 'boolean'],
            'has_expenses' => ['accepted_if:has_stipends,false', 'boolean'],

        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'has_stipends.accepted_if' => __('Please select one means of compensation'),
            'has_expenses.accepted_if' => __('Please select one means of compensation'),
        ];
    }
}
```

The first option can be true only if the second option is false and vice versa.
