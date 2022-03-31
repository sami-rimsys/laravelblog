<?php

namespace Tests\Feature\Scraper;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AppToken;

class ListTokensTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function list_app_tokens()
	{
		$appTokens = AppToken::factory()->count(2)->create();

		$this->artisan('token:list')
			->expectsTable([
		        'App Id',
		        'App Name',
		    ],[
		        [$appTokens[0]->id, $appTokens[0]->name],
		        [$appTokens[1]->id, $appTokens[1]->name],
		    ])
			->assertExitCode(0);
	}
}
