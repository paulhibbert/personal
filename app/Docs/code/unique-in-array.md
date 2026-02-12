# Validating that an array in a request contains unique values

Imagine a form where there is a repeater pattern allowing the user to enter multiple items of the same entity on the form, but that the name attribute must be unique. You cannot have more than one 'Step One' in a series of plan milestones, for example.

Of course its possible to let the database unique constraints handle it, wrap the inserts in a transaction and only commit if all is successful, but this is not particularly friendly for the user, they have to wait for success/failure, and providing feedback in the right place on the form is not so easy.

Also that is not the precognitive way. What we want is to validate the submission as it gets added so the user knows they have made a mistake immediately and before submission.

```php
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueValueInArrayColumn implements DataAwareRule, ValidationRule
{
    public function __construct(protected string $root, protected string $column) {}

    protected $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valuesSubmittedForThisColumn = collect($this->data[$this->root])->pluck($this->column);
        $duplicateValues = $valuesSubmittedForThisColumn->filter(function ($columnValue) use ($value) {
            return trim(strtolower($columnValue)) === trim(strtolower($value));
        });
        $index = (int) explode('.', $attribute)[1];
        /** assume that its the repeat that is the error not the first one */
        if ($duplicateValues->count() > 1 && $index !== $duplicateValues->keys()->first()) {
            $fail(__(':attribute should be unique.', ['attribute' => $attribute]));
        }
    }
}

class ScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'scheduleMilestones' => ['required', 'array'],
            'scheduleMilestones.*.name' => ['required', 'string', new UniqueValueInArrayColumn('scheduleMilestones', 'name')],
        ];
    }
}
```
