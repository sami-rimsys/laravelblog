<?php

namespace Tests\Feature\Scraper;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AppToken;

class SetupTokenTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function setup_new_token()
	{
		$testAppName = 'Client App';

		$this->artisan('token:setup')
			->expectsQuestion('App Name?', $testAppName)
			->expectsOutput("A token has been generated for \"{$testAppName}\"")
			->assertExitCode(0);

		$this->assertEquals(1, AppToken::count());
		$appToken = AppToken::first();
		$this->assertEquals($testAppName, $appToken->name);
		$this->assertNotNull($appToken->api_token);
	}
}
