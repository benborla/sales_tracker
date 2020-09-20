<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
     protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
    * @param array $attributes
    *
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
    * @param $id
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @return array
     */
    public function getFillable(): array
    {
        return $this->model->getFillable();
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(int $id, array $attributes): Model
    {
        if ($this->find($id)->update($attributes)) {
            return $this->find($id);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }
}
