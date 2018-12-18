<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Chatter\Response\ResponseModifier;
use Illuminate\Http\Response;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        response()->macro('api', function ($data = []) {
            return new ResponseModifier($data);
        });
    }
}
