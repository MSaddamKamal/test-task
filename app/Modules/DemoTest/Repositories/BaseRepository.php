<?php

namespace App\Modules\DemoTest\Repositories;

class BaseRepository
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        if($record = $this->findById($id)) {
            $record->update($data);
            return $record->refresh();
        };
        return null;
    }
}
