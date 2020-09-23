<?php

declare(strict_types=1);

namespace App\Repository\Eloquent\User;

use App\Models\User\AccountType;
use App\Repository\Interfaces\User\AccountTypeRepositoryInterface;
use Illuminate\Support\Collection;
use App\Repository\Eloquent\BaseRepository;

class AccountTypeRepository extends BaseRepository implements AccountTypeRepositoryInterface
{
   /**
    * UserRepository constructor.
    *
    * @param \App\Model\User\AccountType $model
    */
   public function __construct(AccountType $model)
   {
       parent::__construct($model);
   }

   public function all()
   {
       return $this->model->all();
   }

   public function paginated()
   {
       return $this->model->paginate();
   }

   public function getOneBy($key, $value)
   {
       return $this->model->query()->where($key, $value)->first();
   }

   public function getAllFromUser($userId)
   {
       return $this->model->query()->where('user_id', $userId)->get();
   }
}
