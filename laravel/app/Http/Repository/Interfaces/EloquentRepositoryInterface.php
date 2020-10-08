<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{
   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes);

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;
}
