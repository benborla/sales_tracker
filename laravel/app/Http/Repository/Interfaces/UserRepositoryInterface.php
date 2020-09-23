<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
   public function all();

   public function paginated();

   public function getOneBy($key, $value);
}
