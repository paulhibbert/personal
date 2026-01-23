<?php

namespace App\Features;

class AllowRegistration
{
    public function __invoke(): bool
    {
        return config('app.features.registration');
    }
}