<?php

declare(strict_types=1);

namespace App\Repository\Eloquent\User;

use App\Models\User\Address;
use App\Repository\Interfaces\User\AddressRepositoryInterface;
use Illuminate\Support\Collection;
use App\Repository\Eloquent\BaseRepository;
use App\Models\User\User;

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
   
   public function getOneByAddresType(int $userId, string $type)
   {
        return $this->model->query()
            ->where('user_id', $userId)
            ->where('type', $type)
            ->first();
   }

   public function getAllFromUser($userId)
   {
       return $this->model->query()->where('user_id', $userId)->get();
   }

   public function add(User $user, array $attributes)
   {
       $attributes['user_id'] = $user->id;
       return parent::create($attributes);
   }

   public function delete(int $id): bool
   {
       return $this->find($id)->delete();
   }
}
