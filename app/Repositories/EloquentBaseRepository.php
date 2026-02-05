<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']): mixed
    {
        return $this->model->all($columns);
    }

    public function find(int $id): mixed
    {
        return $this->model->find($id);
    }

    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $record = $this->find($id);
        if (! $record) {
            return false;
        }

        return $record->update($data);
    }

    public function delete(int $id): bool
    {
        $record = $this->find($id);
        if (! $record) {
            return false;
        }

        return (bool) $record->delete();
    }
}
