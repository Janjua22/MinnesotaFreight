<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Country;
use App\Models\State;
use Auth;
use URL;

class AppServiceProvider extends ServiceProvider{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        // URL::forceScheme('https');

        // if(config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }

        View::composer('*', function($view){
            View::share('COUNTRIES', Country::all());
            View::share('STATES', State::where('country_id', 231)->get()); // American States
        });
    }
}
