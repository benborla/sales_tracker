<?php

declare(strict_types=1);

namespace App\Repository\Interfaces\User;

use Illuminate\Support\Collection;

interface AddressRepositoryInterface
{
   public function all();

   public function paginated();

   public function getOneBy($key, $value);
}
