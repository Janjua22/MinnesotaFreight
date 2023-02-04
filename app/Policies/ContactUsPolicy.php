<?php

        namespace App\Policies;

        use Illuminate\Auth\Access\HandlesAuthorization;
        use App\Models\User;
        use App\Models\Module;

        class ContactUsPolicy
        {
            use HandlesAuthorization;

            /**
            * Stores current module id.
            * 
            * @var int
            */
            protected $module_id;

            /**
            * Create a new policy instance.
            *
            * @return void
            */
            public function __construct(){
                $module = Module::where(["name" => "ContactUs"])->first();

                $this->module_id = $module->id;
            }

            /**
            * Determine if the given user can create.
            *
            * @param  App\Models\User  $user
            * 
            * @return bool
            */
            public function create(User $user){
                return $user->hasPermissions($this->module_id)->create;
            }

            /**
            * Determine if the given user can read.
            *
            * @param  App\Models\User  $user
            * 
            * @return bool
            */
            public function read(User $user){
                return $user->hasPermissions($this->module_id)->read;
            }

            /**
            * Determine if the given user can update.
            *
            * @param  App\Models\User  $user
            * 
            * @return bool
            */
            public function update(User $user){
                return $user->hasPermissions($this->module_id)->update;
            }

            /**
            * Determine if the given user can delete.
            *
            * @param  App\Models\User  $user
            * 
            * @return bool
            */
            public function delete(User $user){
                return $user->hasPermissions($this->module_id)->delete;
            }
        }