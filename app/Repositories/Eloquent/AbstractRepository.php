<?php

namespace App\Repositories\Eloquent;

abstract class AbstractRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->whereId($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function where($whereColumn, $valueColumn)
    {
        return $this->model->where($whereColumn, $valueColumn);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function whereNotIn($whereColumn, array $notIn)
    {
        return $this->model->whereNotIn($whereColumn, $notIn);
    }

    protected function resolveModel()
    {
        return app($this->model);
    }
}
