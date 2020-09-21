<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @return array|User
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
