# A missing string helper for Laravel

As far as I have been able to tell this function does not exist and is sometimes at least useful instead of adding strings to an array and using implode, which more or less does the same job but for simple cases. It does have a simple check to avoid duplicating the connector if its already there.

```php
if (! function_exists(('str_concat'))) {
    /**
     * Connect two or more strings with delimiter
     */
    function str_concat(string $connector, string $first, string ...$stringsToAdd): string
    {
        $out = $first;
        foreach ($stringsToAdd as $stringToAdd) {
            $out = Str::of($out)->endsWith($connector) ? $out.$stringToAdd : $out.$connector.$stringToAdd;
        }
        return $out;
    }
}
```

So both these statements result in the same `foo-bar` output:

```php
str_concat('-', 'foo', 'bar');
str_concat('-', 'foo-', 'bar-');
```
