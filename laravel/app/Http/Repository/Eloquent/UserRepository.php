<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param \App\Model\User $model
    */
   public function __construct(User $model)
   {
       parent::__construct($model);
   }

   /**
    * @return \Illuminate\Support\Collection
    */
   public function all()
   {
       return $this->model->paginate();
   }
}
