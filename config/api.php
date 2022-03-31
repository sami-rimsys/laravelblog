<?php

return [
	
	/*
    |--------------------------------------------------------------------------
    | Page Limit
    |--------------------------------------------------------------------------
    |
    | This value contains the default page limit for api responses.
    |
    */

	'page_limit' => 100,

	/*
    |--------------------------------------------------------------------------
    | Sort Order
    |--------------------------------------------------------------------------
    |
    | This value contains the default attribute and direction by which
    | to sort the the result set.
    |
    */

    'order_by' => [
		'attribute' => 'updated_at',
		'direction' => 'DESC',
    ],
];

