<?php

declare(strict_types=1);

namespace App\Repository\Eloquent\User;

use App\Models\User\Address;
use App\Repository\User\AddressRepositoryInterface;
use Illuminate\Support\Collection;
use App\Repository\Eloquent\BaseRepository;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
   public function __construct(Address $model)
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
