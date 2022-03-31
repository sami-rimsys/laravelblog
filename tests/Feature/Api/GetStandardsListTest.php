<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AppToken;
use App\Models\Standard;
use App\DataProviders\Techstreet;
use Illuminate\Testing\Fluent\AssertableJson;

class GetStandardsListTest extends TestCase
{
	use RefreshDatabase, StandardsTestsDataProviders;

	/*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function unauthorized_applications_receive_an_unauthorized_response()
	{
		$response = $this->withHeaders([
			'X-Rimsys-Server-Token' => 'invalid',
		])->getJson(route('api.standards.index'));

		$response->assertStatus(403);
	}

	/** @test */
	public function user_agent_header_is_required()
	{
		$response = $this->withHeaders([
			'User-Agent' => '',
		])->getJson(route('api.standards.index'));

		$response->assertStatus(403);
	}

	/*
    |--------------------------------------------------------------------------
    | Basic Request
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function can_fetch_all_standards()
	{
		$appToken = AppToken::createNewToken('Test Client');
		$standards = Standard::factory()->count(2)->create();

		$response = $this->withHeaders([
			'X-Rimsys-Server-Token' => $appToken,
		])->getJson(route('api.standards.index'));

		$response->assertStatus(200);
		$response->assertJsonCount(2, 'data');
	}

	/*
    |--------------------------------------------------------------------------
    | Request subset
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function can_fetch_a_subset_of_standards_by_id()
	{
		$requestedStandards = Standard::factory()->count(2)->create();
		$otherStandards = Standard::factory()->count(2)->create();

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'ids' => "{$requestedStandards[0]->id},{$requestedStandards[1]->id}",
			]));

		$response->assertStatus(200);
		$response->assertJsonCount(2, 'data');
		$response->assertJsonFragment(['id' => $requestedStandards[0]->id]);
		$response->assertJsonFragment(['id' => $requestedStandards[1]->id]);
		$response->assertJsonMissing(['id' => $otherStandards[0]->id]);
		$response->assertJsonMissing(['id' => $otherStandards[1]->id]);
	}
	
	/** @test */
	public function can_request_a_subset_of_attributes_using_only_parameter()
	{
		Standard::factory()->create();

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'only' => 'id,title,status,created_at',
			]));

		$response->assertStatus(200);
		$structure = (array_keys($response->decodeResponseJson()['data'][0]));
		$this->assertEquals($structure, [
			'id',
	        'title',
	        'status',
	        'created_at',
		]);
	}

	/** @test */
	public function can_request_a_subset_of_attributes_using_except_parameter()
	{
		Standard::factory()->create();
		$excludedAttributes = collect([
			'id',
			'title',
			'status',
			'created_at',
		]);
		$expectedAttributes = collect(Standard::getTableColumns())
			->reject(fn($attribute) 
				=> $excludedAttributes->contains($attribute));

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'except' => $excludedAttributes->implode(','),
			]));

		$response->assertStatus(200);
		$structure = (array_keys($response->decodeResponseJson()['data'][0]));
		$this->assertEquals($structure, $expectedAttributes->values()->toArray());
	}

	/*
    |--------------------------------------------------------------------------
    | Ordering
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function response_data_is_sorderd_decending_by_updated_at_by_default()
	{
		$expectedSecondStandard = Standard::factory()->create(['updated_at' => now()->subDay()]);
		$expectedFirstStandard = Standard::factory()->create(['updated_at' => now()]);
		$expectedThirdStandard = Standard::factory()->create(['updated_at' => now()->subDays(2)]);

		$response = $this->auth()
			->getJson(route('api.standards.index'));

		$response->assertStatus(200);
		$response->assertJson([
			'data' => [
				[
					'id' => $expectedFirstStandard->id,
				], [
					'id' => $expectedSecondStandard->id,
				], [
					'id' => $expectedThirdStandard->id,
				],
			],
		]);

	}

	/** @test */
	public function can_pass_a_model_attribute_to_receive_results_sorted_by_that_attrubute_in_default_order()
	{
		$expectedSecondStandard = Standard::factory()->create(['title' => 'B']);
		$expectedFirstStandard = Standard::factory()->create(['title' => 'C']);
		$expectedThirdStandard = Standard::factory()->create(['title' => 'A']);
		
		config(['api.order_by' => [
			'attribute' => 'updated_at',
			'direction' => 'DESC',
		]]);

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'order_by' => 'title',
			]));

		$response->assertStatus(200);
		$response->assertJson([
			'data' => [
				[
					'id' => $expectedFirstStandard->id,
				], [
					'id' => $expectedSecondStandard->id,
				], [
					'id' => $expectedThirdStandard->id,
				],
			],
		]);

	}

	/** @test */
	public function can_pass_a_formatted_direction_model_attribute_parameter_to_receive_results_sorted_by_the_attribute_in_the_direction()
	{
		$expectedSecondStandard = Standard::factory()->create(['title' => 'B']);
		$expectedFirstStandard = Standard::factory()->create(['title' => 'A']);
		$expectedThirdStandard = Standard::factory()->create(['title' => 'C']);
		
		config(['api.order_by' => [
			'attribute' => 'updated_at',
			'direction' => 'DESC',
		]]);

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'order_by' => 'asc:title',
			]));

		$response->assertStatus(200);
		$response->assertJson([
			'data' => [
				[
					'id' => $expectedFirstStandard->id,
				], [
					'id' => $expectedSecondStandard->id,
				], [
					'id' => $expectedThirdStandard->id,
				],
			],
		]);

	}

	/** @test */
	// @TOTO: add a data provider test asc and desc directions
	public function can_pass_a_sort_attribute_and_sort_direction()
	{
		$expectedSecondStandard = Standard::factory()->create(['title' => 'B']);
		$expectedFirstStandard = Standard::factory()->create(['title' => 'A']);
		$expectedThirdStandard = Standard::factory()->create(['title' => 'C']);
		
		config(['api.order_by' => [
			'attribute' => 'updated_at',
			'direction' => 'DESC',
		]]);

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'order_by' => 'asc:title',
			]));

		$response->assertStatus(200);
		$response->assertJson([
			'data' => [
				[
					'id' => $expectedFirstStandard->id,
				], [
					'id' => $expectedSecondStandard->id,
				], [
					'id' => $expectedThirdStandard->id,
				],
			],
		]);

	}

	/*
    |--------------------------------------------------------------------------
    | Filtering
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function can_filter_by_attribute_value()
	{
		$expectedStandards = Standard::factory()
			->count(2)
			->current()
			->techstreet()
			->create();
		$unexpectedStandardWithSharedAttributes = Standard::factory()
			->withdrawn()
			->techstreet()
			->create();
		$unexpectedStandardsWithoutSharedAttributes = Standard::factory()
			->count(2)
			->withdrawn()
			->create();

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'status' => Techstreet::CURRENT,
			]));

		$response->assertStatus(200);
		$response->assertJsonCount(2, 'data');
		$response->assertJsonFragment(['id' => $expectedStandards[0]->id]);
		$response->assertJsonFragment(['id' => $expectedStandards[1]->id]);
		$response->assertJsonMissing(['id' => $unexpectedStandardWithSharedAttributes->id]);
		$response->assertJsonMissing(['id' => $unexpectedStandardsWithoutSharedAttributes[0]->id]);
		$response->assertJsonMissing(['id' => $unexpectedStandardsWithoutSharedAttributes[1]->id]);
	}

	/*
    |--------------------------------------------------------------------------
    | Offset Pagination - @TODO switch to a more performant pagination like
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function authorized_applications_can_request_a_page_limit_on_results()
	{
		$requestedStandards = Standard::factory()->count(4)->create();
		$requestedLimit = 2;

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'limit' => $requestedLimit,
			]));

		$response->assertStatus(200);
		$response->assertJsonCount($requestedLimit, 'data');
	}

	/** @test */
	public function authorized_applications_receive_a_default_page_limit()
	{
		$requestedStandards = Standard::factory()->count(4)->create();
		$defaultLimit = 3;
		config(['api.page_limit' => $defaultLimit]);

		$response = $this->auth()
			->getJson(route('api.standards.index'));

		$response->assertStatus(200);
		$response->assertJsonCount($defaultLimit, 'data');
		$response->assertJsonFragment(['per_page' => $defaultLimit]);
		$response->assertJsonFragment(['current_page' => 1]);
	}

	/** @test */
	public function can_pass_a_page_parameter()
	{
		$expectedFirstStandard = Standard::factory()->create(['updated_at' => now()->subDays(2)]);
		$expectedSecondStandard = Standard::factory()->create(['updated_at' => now()->subDay()]);
		$expectedThirdStandard = Standard::factory()->create(['updated_at' => now()]);

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'limit' => 2,
				'page' => 2,
			]));

		$response->assertStatus(200);
		$response->assertjsonCount(1, 'data');
		$response->assertJson([
			'current_page' => 2,
			'data' => [
				[
					'id' => $expectedFirstStandard->id,
				]
			]
		]);
	}

	/** @test */
	public function json_response_contains_the_expected_response_pagination_attributes()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index'));

		$response->assertJson(fn (AssertableJson $json) =>
		    $json->has('total')
		    	->has('per_page')
		    	->has('current_page')
		    	->has('last_page')
		    	->has('first_page_url')
				->has('last_page_url')
				->has('next_page_url')
				->has('prev_page_url')
				->has('data')
		    	->etc()
			);
	}

	/*
    |--------------------------------------------------------------------------
    | Basic Search
    |--------------------------------------------------------------------------
	*/

    /** 
     * @test 
     * @dataProvider searchAttributesDataProvider
     */
    public function can_search_attributes_with_query_parameter($attribute, $query, $expectedStandards, $unexpectedStandards)
    {
    	$expectedStandardModels = $expectedStandards->map(fn($attributeValue) 
    		=> Standard::factory()->create([$attribute => $attributeValue]));
    	$unexpectedStandardsModels = $unexpectedStandards->map(fn($attributeValue) 
    		=> Standard::factory()->create([$attribute => $attributeValue]));

    	$response = $this->auth()
			->getJson(route('api.standards.index', [
				'q' => $query,
			]));

		$response->assertStatus(200);
		$response->assertJsonCount($expectedStandardModels->count(), 'data');
		$response->assertJson([
			'data' => $expectedStandardModels->map(fn($standard) =>
				[
					$attribute => $standard->$attribute,
				]
			)->toArray(),
		]);
    }

	/*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
	*/

	/** @test */
	public function formatted_sort_order_attribute_string_must_contain_a_valid_sort_order()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'order_by' => 'invalid:title',
			]));

		$response->assertJsonValidationErrorFor('order_by');
	}

	/** @test */
	public function formatted_sort_order_attribute_string_must_contain_a_valid_value()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'order_by' => 'asc:invalid',
			]));

		$response->assertJsonValidationErrorFor('order_by');
	}

	/** @test */
	public function sort_order_attribute_string_must_contain_a_valid_value()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'order_by' => 'invalid',
			]));

		$response->assertJsonValidationErrorFor('order_by');
	}


	/** @test */
	public function can_not_pass_an_invalid_attribute()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'invalid_attribute' => 'irrelevant value',
			]));

		$response->assertJsonValidationErrorFor('invalid_attribute');
	}

	/** @test */
	public function requesting_non_numeric_ids_returns_an_error()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'ids' => '1,2,b',
			]));

		$response->assertJsonValidationErrorFor('ids');
	}

	/** @test */
	public function requesting_more_than_100_ids_returns_an_error()
	{
		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'ids' => implode(",", range(1,101)),
			]));

		$response->assertJsonValidationErrorFor('ids');
	}

	/** @test */
	public function requesting_ids_that_do_not_exist_returns_an_error()
	{
		$standardId = Standard::factory()->create()->id;

		$response = $this->auth()
			->getJson(route('api.standards.index', [
				'ids' => "{$standardId},10,11",
			]));

		$response->assertJsonValidationErrorFor('ids');
	}
}
