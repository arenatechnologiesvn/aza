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
    protected $model;
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
        return $this->model->select($this->selectable)->FirstOrFail($id);
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
        try {
            DB::beginTransaction();
            if (method_exists($this, 'beforeCreate')) {
                $data = $this->beforeCreate($data);
            }
            $saved = $this->model->create($data);
            if(method_exists($this, 'afterSave')) {
                $this->afterSave($saved, $data, false);
            }
            DB::commit();
            return $this->getById($saved->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();
            $updated = $this->model->find($id);
            if (method_exists($this, 'beforeUpdate')) {
                $data = $this->beforeUpdate($updated, $data);
            }
            if(method_exists($this, 'afterSave')) {
                $this->afterSave($updated, $data, true);
            }
            DB::commit();
            return $this->getById($id);
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
