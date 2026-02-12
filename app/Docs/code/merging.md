# Using FormRequest Authorize to inject the user model into the request

In this example the request is an account activation request from a signed url, the email address is provided and must be matched against the user email address in the DB which is stored as a hash. If all the checks are successful the user model is merged into the request so the controller can treat the request as if route model binding had been applied.

```php
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AccountActivationRequest extends EmailVerificationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! request()->hasValidSignature()) {
            return false;  // url has been tampered with
        }

        $user = User::whereEmail(your_hash_function($this->email))->first();

        if (empty($user)) {
            return false;  // no user for this email
        }

        if (! $user->modelHasRoles()->count()) {
            return false; // user has no roles to activate
        }

        $hashAlgo = config('app.link_hash_algo');
        if (! hash_equals(hash($hashAlgo, $user->uuid), $this->route('hash'))) {
            return false;  // belt and braces why not !
        }

        $this->merge(['user' => $user]); // pass the user into the controller

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required'],
            'user' => ['required'],
        ];
    }
}
```

By adding the user to the rules as a required field, its also possible to access via `request()->validated()`.
