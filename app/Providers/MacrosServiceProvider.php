<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
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
        Builder::macro('requestBuilder', function() {
            if (request('whereAttributes')) {
                foreach (request('whereAttributes') as $index => $attribute) {
                    $this->where(
                        $attribute,
                        request('whereOperators')[$index],
                        request('whereValues')[$index]
                    );
                }
            }
            if (request('nullAttributes')) {
                foreach (request('nullAttributes') as $attribute) {
                    $this->whereNull($attribute);
                }
            }
        });
    }
}
