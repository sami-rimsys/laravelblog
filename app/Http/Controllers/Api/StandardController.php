<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Standard;
use App\Http\Requests\GetStandardsRequest;

class StandardController extends Controller
{
    public function index(GetStandardsRequest $request)
    {
        $standards = Standard::query();

        // apply ids parameter filter
        if ($request->ids && ! empty ($standardIds = explode(',', $request->ids))) {
            $standards->whereIn('id', $standardIds);
        }

        // apply sort order
        $standards->orderBy($request->order_by_attribute, $request->order_by_direction);

        // apply filter by model attributes
        collect($request->only(Standard::getTableColumns()))
            ->each(function ($value, $attribute) use (&$standards) {
                $standards->where($attribute, $value);
            });

        // apply search filter
        if ($request->q) {
            $standards->where(function ($query) use ($request) {
                collect(Standard::getTableColumns())->each(function ($attribute) use ($request, &$query) {
                    return $query->orWhere($attribute, 'LIKE', "%{$request->q}%");
                });
            });
        }

        return $standards->paginate($request->limit, $request->model_attributes)
            ->withQueryString();
    }
}
