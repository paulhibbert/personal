<?php

namespace App\Features;

class AllowLogin
{
    public function __invoke(): bool
    {
        return config('app.features.login');
    }
}