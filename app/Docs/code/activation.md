# Validating an account activation form request

In this case the email address is already stored on the user account (encrypted) but on the form for the user for information the unencrypted email address is shown in a read-only disabled form input element (the unencrypted email address was available but the details of that don't matter here). Never trust anything that comes from the front end, so there is also a hidden field containing the stored hash. In another case the email address field might be for the user to fill in for confirmation and the error message would be different.

```php
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ValueHasNotBeenAltered implements DataAwareRule, ValidationRule
{
    protected $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (your_hash_function($value) !== $this->data['hash']) {
            $fail(__('Email address appears to have been altered'));
        }
    }
}
```

In the FormRequest the rule is applied to the email address input, but needs data from another field, the hash input to validate it, hence the DataAwareRule usage. There is of course no need to validate the email address as an email address in this case since if it were not valid it could not possibly match the hashed value.

```php
    public function rules()
    {
        return [
            'email' => ['required', 'string', new ValueHasNotBeenAltered],
            'hash' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'password' => ['required',
                Password::min(8)
                    ->max(app(HeronPasswordCriteria::class)::USER_MAX_PASSWORD_LENGTH)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                new PasswordDoesNotContainNames,
            ],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
```

This validation rule set also includes the [PasswordDoesNotContainNames](articles/validation) rule.
