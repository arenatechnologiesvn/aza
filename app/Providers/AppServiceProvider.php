<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Validator;
use App\Employee;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->extendValidators();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    private function extendValidators()
    {
        Validator::extend('is_sale_employee', function($attribute, $value, $parameters, $validator) {
            if(!empty($value)) {
                if ($employee = Employee::where('code', '=', $value)->first()) {
                    if ($employee_user = User::find($employee->user_id)) {
                        if ($employee_user->role_id == 3) return true;
                    }
                }
            }
            return false;
        });

        Validator::extend('is_active_employee', function($attribute, $value, $parameters, $validator) {
            if(!empty($value)) {
                if ($employee = Employee::where('code', '=', $value)->first()) {
                    if ($employee_user = User::find($employee->user_id)) {
                        if ($employee_user->is_active && $employee_user->is_verified) return true;
                    }
                }
            }
            return false;
        });
    }
}
