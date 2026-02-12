# Laravel custom validation rule

Hopefully the code speaks for itself.

```php
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordDoesNotContainNames implements DataAwareRule, ValidationRule
{
    protected $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! array_key_exists('first_name', $this->data) || ! array_key_exists('last_name', $this->data)) {
            return;
        }
        if ($attribute !== 'password') {
            return;
        }

        if (empty($this->data['first_name']) || empty($this->data['last_name'])) {
            return;
        }

        $firstNameMatch = '/'.strtolower($this->data['first_name']).'/';
        $lastNameMatch = '/'.strtolower($this->data['last_name']).'/';
        $lowerCasePassword = strtolower($value);

        if (preg_match($firstNameMatch, $lowerCasePassword) || preg_match($lastNameMatch, $lowerCasePassword)) {
            $fail(__('validation.custom.password.exclude_personal_information'));
        }
    }
}
```
