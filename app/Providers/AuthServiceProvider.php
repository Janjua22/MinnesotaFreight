<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Module;

class AuthServiceProvider extends ServiceProvider{
    
    protected $modules;
    
    /**
    * Create a new policy instance.
    *
    * @return void
    */
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(){
        $this->modules = Module::all();
        $this->registerPolicies();
        
        if($this->modules->isNotEmpty()){
            foreach ($this->modules as $key => $module) {
                $name = $module->name;
                $this->getAllPolicies($name);
            }
        }
    }

    function getAllPolicies($name){
        Gate::define("create-$name", "App\Policies\\".$name."Policy@create");
        Gate::define("read-$name", "App\Policies\\".$name."Policy@read");
        Gate::define("update-$name", "App\Policies\\".$name."Policy@update");
        Gate::define("delete-$name", "App\Policies\\".$name."Policy@delete");
    }
}
