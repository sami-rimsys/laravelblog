<?php

namespace Tests\Feature\Scraper;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AppToken;

class RegenerateTokenTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function regenerate_token()
	{
		$appTokens = AppToken::factory()->count(2)->create();
		$originalToken = $appTokens[0]->api_token;

		$this->artisan('token:refresh')
			->expectsTable([
		        'App Id',
		        'App Name',
		    ],[
		        [$appTokens[0]->id, $appTokens[0]->name],
		        [$appTokens[1]->id, $appTokens[1]->name],
		    ])
			->expectsQuestion('Enter the ID of the token you\'d like to refresh', $appTokens[0]->id)
			->expectsOutput('Be sure to copy this token. It will only be displayed here.')
			->assertExitCode(0);

		$this->assertTrue($originalToken != $appTokens->fresh()[0]->api_token);
	}

	/** @test */
	public function attempting_to_regenerate_a_token_for_an_unknown_id_throws_an_error()
	{
		$appTokens = AppToken::factory()->create();
		$invalidId = 9999;

		$this->artisan('token:refresh')
			->expectsQuestion('Enter the ID of the token you\'d like to refresh', $invalidId)
			->expectsOutput("The ID \"{$invalidId}\" could not be found. Please choose an id from the table above.")
			->assertExitCode(1);
	}
}
