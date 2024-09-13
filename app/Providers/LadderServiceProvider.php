<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Ladder\Ladder;

class LadderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Ladder::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Ladder::role('user', 'User', [
            'create',
            'read',
            'update',   
            'delete',
        ])->description('User users can only read data.');

    }
}
