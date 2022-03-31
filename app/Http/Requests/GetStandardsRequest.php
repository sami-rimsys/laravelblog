<?php

namespace App\Http\Requests;

use App\Models\AppToken;
use App\Models\Standard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class GetStandardsRequest extends FormRequest
{

    /**
     * Define the validation rules to be used
     *
     * @var array
     */
    protected $validationRules = [];

    /**
     * Define the valid query parameters that can be used
     *
     * @var array
     */
    protected $validQueryParameters = [
        'except',
        'ids',
        'limit',
        'only',
        'order_by',
        'page',
        'q',
    ];

    /**
     * Define the valid strings that can be used when modifying the sort direction
     *
     * @var array
     */
    protected $validSortOrderDirections = [
        'asc',
        'desc',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AppToken::authenticate($this->header('X-Rimsys-Server-Token'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->validationRules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->buildIdsParameterRules();
        $this->buildInvalidParametersRules();
        $this->buildOrderByParameterRules();

        // normalize parameters
        $this->merge(
            array_merge(
                $this->normalizeOrderByParameter(),
                [
                    'limit' => $this->pageLimit(),
                    'model_attributes' => $this->modelAttributes(),
                ]
            )
        );
    }

    /**
     * Normalize the limit value on the request
     *
     * @return string
     */
    protected function pageLimit()
    {
        return $this->limit ?: config('api.page_limit');
    }

    /**
     * Normalize the model_attributes value on the request
     *
     * @return string
     */
    protected function modelAttributes()
    {
        $columns = ['*'];

        if ($this->except) {
            $columns = collect(Standard::getTableColumns())
                ->reject(fn($item) 
                    => collect(explode(',', $this->except))->contains($item))
                ->toArray();
        } elseif ($this->only) {
            $columns = explode(',', $this->only);
        }

        return $columns;
    }

    /**
     * Normalize the order_by query parameter
     *
     * @return array
     */
    protected function normalizeOrderByParameter()
    {
        if ($this->order_by && Str::contains($this->order_by, ':')) {
            [$orderDirection, $orderAttribute] = explode(':', $this->order_by);
        } elseif ($this->order_by) {
            $orderAttribute = $this->order_by;
            $orderDirection = config('api.order_by.direction');
        } else {
            $orderAttribute = config('api.order_by.attribute');
            $orderDirection = config('api.order_by.direction');
        }

        return [
            'order_by_attribute' => $orderAttribute,
            'order_by_direction' => $orderDirection,
        ];
    }

    /**
     * Append a rule to the array of rules for validation
     * 
     * @return void
     */
    protected function appendRule($attribute, $rule)
    {
        $this->validationRules[$attribute] = $rule;
    }

    /**
     * Generate an array of allowable query parameters
     * 
     * @return array
     */
    protected function validQueryParameters()
    {
        return array_merge(
            Standard::getTableColumns(),
            $this->validQueryParameters
        );
    }

    /**
     * Build the validation ruleset for the `ids` query parameter
     * 
     * @return void
     */
    protected function buildIdsParameterRules()
    {
        $this->appendRule('ids', function ($attribute, $value, $fail) {
            $ids = collect(explode(',', $value));

            // check if ids are empty
            if ($ids->isEmpty()) {
                $fail('The '.$attribute.' is empty.');
            }

            // check if more than 100 ids were requested
            if ($ids->count() > 100) {
                $fail('The '.$attribute.' contains more than the upper limit of 100 ids.');
            }

            // check if ids are not numeric
            if ($ids->filter(fn ($id) => ! is_numeric($id))->count() > 0) {
                $fail('The '.$attribute.' contains non-numeric values.');
            }

            // check if ids can not be found in the DB
            $validIds = Standard::whereIn('id', $ids->toArray())->pluck('id');
            $invalidIds = $ids->filter(fn ($id) => $validIds->doesntContain($id));

            if ($invalidIds->isNotEmpty()) {
                $fail('The '.$attribute.' contains the ids that can not be found. ids: {' . $invalidIds->implode(', ') . '}');
            }
        });
    }

    /**
     * Build the validation ruleset for invalid query parameters
     * 
     * @return void
     */
    public function buildInvalidParametersRules()
    {
        collect($this->all())
            ->reject(fn ($value, $parameter) => in_array($parameter, $this->validQueryParameters()))
            ->each(function ($value, $parameter) {
                $this->appendRule($parameter, function ($attribute, $value, $fail) {
                    $fail('The invalid parameter ' . $attribute . ' was found.');
                });
            });
    }

    /**
     * Build the validation ruleset for `order_by` parameter values
     * 
     * @return void
     */
    public function buildOrderByParameterRules()
    {
        $orderByQueryParameter = 'order_by';

        // fail on invalid sort order direction
        collect($this->$orderByQueryParameter)
            ->filter(fn ($value, $parameter) => Str::contains($value, ':'))
            ->each(function ($queryStringValue) use ($orderByQueryParameter) {
                [$direction, $modelAttribute] = explode(':', $queryStringValue);
                if (! in_array($direction, $this->validSortOrderDirections)) {
                    $this->appendRule($orderByQueryParameter, function ($attribute, $value, $fail) use ($direction, $orderByQueryParameter, $modelAttribute) {
                        $fail("Invalid sort order '{$direction}' was found in '{$orderByQueryParameter}={$direction}:{$modelAttribute}' ");
                    });
                }
            });

        // fail on invalid sort order value
        collect($this->$orderByQueryParameter)
            ->each(function ($queryStringValue) use ($orderByQueryParameter) {
                if (Str::contains($queryStringValue, ':')) {
                    [$direction, $modelAttribute] = explode(':', $queryStringValue);
                } else {
                    $modelAttribute = $queryStringValue;
                }
                if (! in_array($modelAttribute, Standard::getTableColumns())) {
                    $this->appendRule($orderByQueryParameter, function ($attribute, $value, $fail) use ($modelAttribute, $queryStringValue, $orderByQueryParameter) {
                        $fail("Invalid sort attribute '{$modelAttribute}' was found in '{$orderByQueryParameter}={$queryStringValue}' ");
                    });
                }
            });
    }
}
