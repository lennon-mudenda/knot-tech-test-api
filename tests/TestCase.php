<?php

namespace Tests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        $this->artisan('db:seed');
    }

    protected function urlFromTemplate(string $template, array $params = []): string
    {
        $url = $template;

        foreach ($params as $paramKey => $paramValue)
        {
            $url = Str::replace( '{' . $paramKey . '}', $paramValue, $url);
        }

        return '/api/v1' . $url;
    }
}
