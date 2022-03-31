<?php

namespace Tests\Feature\Scraper;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AppToken;

class DeleteTokenTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function token_is_deleted_if_a_user_confirms_yes()
	{
		$appTokens = AppToken::factory()->count(2)->create();
		$appTokenToDelete = $appTokens->first();

		$this->artisan('token:delete')
			->expectsTable([
		        'App Id',
		        'App Name',
		    ],[
		        [$appTokens[0]->id, $appTokens[0]->name],
		        [$appTokens[1]->id, $appTokens[1]->name],
		    ])
			->expectsQuestion('Enter the ID of the token you\'d like to delete', $appTokenToDelete->id)
			->expectsConfirmation("Confirm that you would like to delete the token for \"{$appTokenToDelete->name}\"", 'yes')
			->expectsOutput("The token for \"{$appTokenToDelete->name}\" has been deleted")
			->assertExitCode(0);

		$this->assertEquals(1, AppToken::count());
		$this->assertNull(AppToken::find($appTokenToDelete->id));
	}

	/** @test */
	public function token_is_not_deleted_if_a_user_confirms_yes()
	{
		$appTokens = AppToken::factory()->count(2)->create();
		$appTokenToDelete = $appTokens->first();

		$this->artisan('token:delete')
			->expectsTable([
		        'App Id',
		        'App Name',
		    ],[
		        [$appTokens[0]->id, $appTokens[0]->name],
		        [$appTokens[1]->id, $appTokens[1]->name],
		    ])
			->expectsQuestion('Enter the ID of the token you\'d like to delete', $appTokenToDelete->id)
			->expectsConfirmation("Confirm that you would like to delete the token for \"{$appTokenToDelete->name}\"", 'no')
			->expectsOutput("The token for \"{$appTokenToDelete->name}\" has not been deleted")
			->assertExitCode(0);

		$this->assertEquals(2, AppToken::count());
		$this->assertNotNull(AppToken::find($appTokenToDelete->id));
	}



	/** @test */
	public function attempting_to_delete_a_token_for_an_unknown_id_throws_an_error()
	{
		$appTokens = AppToken::factory()->create();
		$invalidId = 9999;

		$this->artisan('token:delete')
			->expectsQuestion('Enter the ID of the token you\'d like to delete', $invalidId)
			->expectsOutput("The ID \"{$invalidId}\" could not be found. Please choose an id from the table above.")
			->assertExitCode(1);
	}
}
