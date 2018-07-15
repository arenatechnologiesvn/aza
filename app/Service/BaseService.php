<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/12/2018
 * Time: 12:35 AM
 */

namespace App\Service;


use App\BaseModel;
use Illuminate\Support\Facades\DB;

abstract class BaseService
{
    public $model;
    protected $selectable = [
        'id'
    ];

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function getById($id, $selectable = null)
    {
        if (method_exists($this, 'toDto')) {
            return $this->toDto($selectable)->find($id);
        }
        return $this->model->select($this->selectable)->findOrFail($id);
    }

    public function getAll($selectable = false)
    {
        if (method_exists($this, 'toDto')) {
            return $this->toDto($selectable)->get();
        }
        return $this->model->select($this->selectable)->get();
    }

    public function create(array $data)
    {
        if (method_exists($this, 'beforeSave')) {
            $data = $this->beforeSave();
        }
        DB::beginTransaction();
        try {
            $saved = $this->model->create($data);
            DB::commit();
            return $saved;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        if (method_exists($this, 'beforeSave')) {
            $data = $this->beforeSave();
        }
        DB::beginTransaction();
        try {
            $updated = $this->model->find($id);
            $updated->update($data);
            DB::commit();
            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy($id)
    {
        $data = $this->model->find($id);
        if ($data) {
            DB::beginTransaction();
            try {
                if ($data) {
                    $data->delete();
                    DB::commit();
                    return $this->model->onlyTrashed()->find($id);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
