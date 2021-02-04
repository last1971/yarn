<?php

namespace App\Providers;

use App\Models\ParameterValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

/**
 * @method where(mixed $attribute, mixed $index, mixed $index1)
 */
class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('arrayBuilder', function(array $request) {
            if ($this->model instanceof Product && isset($request['selectedParameters'])) {
                foreach ($request['selectedParameters'] as $parameterNameId => $values) {
                    $this->whereIn('id', ParameterValue::select('product_id')
                        ->where(function (Builder $query) use ($parameterNameId, $values) {
                            foreach ($values as $value) {
                                $query->orWhere(function (Builder $insideQuery) use ($parameterNameId, $value) {
                                    $insideQuery
                                        ->where('parameter_name_id', $parameterNameId)
                                        ->where('string_value', $value['string_value'])
                                        ->where('numeric_value', $value['numeric_value'])
                                        ->where('fraction', $value['fraction'])
                                        ->where('parameter_unit_id', $value['parameter_unit_id']);
                                });
                            }
                        })
                    );
                }
            }
            if (isset($request['whereAttributes'])) {
                foreach ($request['whereAttributes'] as $index => $attribute) {
                    $this->where(
                        $attribute,
                        $request['whereOperators'][$index],
                        $request['whereValues'][$index]
                    );
                }
            }
            if (isset($request['havingAttributes'])) {
                foreach ($request['havingAttributes'] as $index => $attribute) {
                    $this->having(
                        $attribute,
                        $request['havingOperators'][$index],
                        $request['havingValues'][$index]
                    );
                }
            }
            if (isset($request['nullAttributes'])) {
                foreach ($request['nullAttributes'] as $attribute) {
                    $this->whereNull($attribute);
                }
            }
            if (isset($request['sortBy'])) {
                foreach ($request['sortBy'] as $index => $orderBy) {
                    $this->orderBy($orderBy, $request['sortDesc'][$index] === 'true' ? 'desc' : 'asc');
                }
            }
            if (isset($request['with'])) {
                $this->with($request['with']);
            }
            return $this;
        });

        Builder::macro('requestBuilder', function () {
            return $this->arrayBuilder(request()->query() ?? []);
        });
    }
}
