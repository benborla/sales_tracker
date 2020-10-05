<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * IMPORTANT!
 * Do not manually modify this file, this file is auto-generated
 *
 * RepositoryServiceProvider
 *
 * @uses ServiceProvider
 * @copyright 2020
 * @author Ben Borla <benborla@icloud.com>
 * @license PHP Version 7.4.9 {@link http://www.php.net/license/}
 */
class RepositoryServiceProvider extends ServiceProvider
{
   /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        $this->app->bind(\App\Repository\Interfaces\EloquentRepositoryInterface::class, \App\Repository\Eloquent\BaseRepository::class);
        $this->app->bind(\App\Repository\Interfaces\UserRepositoryInterface::class, \App\Repository\Eloquent\UserRepository::class);
        $this->app->bind(\App\Repository\Interfaces\User\AddressRepositoryInterface::class, \App\Repository\Eloquent\User\AddressRepository::class);
		$this->app->bind(\App\Repository\Interfaces\User\AccountTypeRepositoryInterface::class, \App\Repository\Eloquent\User\AccountTypeRepository::class);
		$this->app->bind(\App\Repository\Interfaces\User\BillingRepositoryInterface::class, \App\Repository\Eloquent\User\BillingRepository::class);
		// @register
    }
}
