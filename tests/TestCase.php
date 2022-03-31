<?php

namespace Tests;

use App\Models\AppToken;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function auth()
    {
        return $this->withHeaders([
            'X-Rimsys-Server-Token' => AppToken::createNewToken('Test Client'),
        ]);
    }
}
