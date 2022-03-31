<?php

namespace Tests\Feature\Api;

Trait StandardsTestsDataProviders
{
	public function searchAttributesDataProvider()
    {
    	return [
    		'Searching by `number` failed' => [
    			'number',
    			'1234',
    			collect([
    				'12345',
    				'12346',
    			]),
    			collect([
    				'9876',
    				'4512',
    			])
    		],
    		'Searching by `title` failed' => [
    			'title',
    			'test title',
    			collect([
    				'This test title should be returned',
    				'This test title should also be returned',
    			]),
    			collect([
    				'This should not be returned',
    			])
    		],
    		'Searching by `url` failed' => [
    			'url',
    			'techstreet.com',
    			collect([
    				'https://www.techstreet.com/standards/din-iec-pas-62569-1?product_id=1871667',
    				'https://www.techstreet.com/standards/iso-9001-2015?product_id=1902439',
    			]),
    			collect([
    				'https://standards.iteh.ai/catalog/standards/sist/9f17b6aa',
    			])
    		],
    		'Searching by `provider` failed' => [
    			'provider',
    			'techstreet',
    			collect([
    				'techstreet',
    				'techstreet',
    			]),
    			collect([
    				'iteh',
    			])
    		],
    		'Searching by `overview` failed' => [
    			'overview',
    			'test search query',
    			collect([
    				'This overview contains test search query an other text',
    				'This overview also contains test search query an other text',
    			]),
    			collect([
    				'This overview also does not contains test query',
    			])
    		],
    		'Searching by `status` failed' => [
    			'status',
    			'withdrawn',
    			collect([
    				'withdrawn',
    				'withdrawn',
    			]),
    			collect([
    				'current',
    			])
    		],
    		'Searching by `year` failed' => [
    			// years don't have yYYYY. this is a hack so the string 2022 doesn't conflict with other
    			// columns which would return unexpected results
    			'year',
    			'y2022',
    			collect([
    				'y2022',
    				'y2022',
    			]),
    			collect([
    				'y2021',
    			])
    		],
    		'Searching by `publisher` failed' => [
    			'publisher',
    			'search publisher',
    			collect([
    				'first search publisher',
    				'second search publisher',
    			]),
    			collect([
    				'third publisher',
    			])
    		],
    		'Searching by `provider_standard_id` failed' => [
    			'provider_standard_id',
    			'123456',
    			collect([
    				'1234567890',
    				'1234561234',
    			]),
    			collect([
    				'987654321',
    			])
    		],
    		'Searching by `isbn` failed' => [
    			'isbn',
    			'978-3-16-148410-0',
    			collect([
    				'978-3-16-148410-0',
    			]),
    			collect([
    				'978-3-16-148410-1',
    				'123-3-16-148410-0',
    			])
    		],
    		// @TODO Dates aren't strings so these will need to be handeled differently the searching on the rest
    		// 'Searching by `changed_at` failed' => [
    		// 	'changed_at',
    		// 	'2022-01',
    		// 	collect([
    		// 		'2022-01-01',
    		// 		'2022-01-02',
    		// 	]),
    		// 	collect([
    		// 		'2022-02-01',
    		// 	])
    		// ],
    		// 'Searching by `publication_date` failed' => [
    		// 	'publication_date',
    		// 	'2022-01',
    		// 	collect([
    		// 		'2022-01-01',
    		// 		'2022-01-02',
    		// 	]),
    		// 	collect([
    		// 		'2022-02-01',
    		// 	])
    		// ],
    		// 'Searching by `withdrawn_date` failed' => [
    		// 	'withdrawn_date',
    		// 	'2022-01',
    		// 	collect([
    		// 		'2022-01-01',
    		// 		'2022-01-02',
    		// 	]),
    		// 	collect([
    		// 		'2022-02-01',
    		// 	])
    		// ],
    		// 'Searching by `updated_at` failed' => [
    		// 	'updated_at',
    		// 	'2022-01',
    		// 	collect([
    		// 		'2022-01-01',
    		// 		'2022-01-02',
    		// 	]),
    		// 	collect([
    		// 		'2022-02-01',
    		// 	])
    		// ],
    		// 'Searching by `created_at` failed' => [
    		// 	'created_at',
    		// 	'2022-01',
    		// 	collect([
    		// 		'2022-01-01',
    		// 		'2022-01-02',
    		// 	]),
    		// 	collect([
    		// 		'2022-02-01',
    		// 	])
    		// ]
    	];
    }
}