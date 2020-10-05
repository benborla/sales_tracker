<?php

declare(strict_types=1);

namespace App\Repository\Eloquent\User;

use App\Models\User\Billing;
use App\Repository\Interfaces\User\BillingRepositoryInterface;
use Illuminate\Support\Collection;
use App\Repository\Eloquent\BaseRepository;

class BillingRepository extends BaseRepository implements BillingRepositoryInterface
{
   /**
    * UserRepository constructor.
    *
    * @param \App\Model\User\Billing $model
    */
   public function __construct(Billing $model)
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
}
