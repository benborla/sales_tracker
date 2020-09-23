<?php

declare(strict_types=1);

namespace App\Repository\Hello;

use Illuminate\Support\Collection;

interface TestRepositoryInterface
{
   public function all();

   public function paginated();

   public function getOneBy($key, $value);
}
