<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\User\AddressRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\User\AddressRepository;
use App\Repository\Eloquent\BaseRepository;
// @import

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
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        // @register
    }
}
