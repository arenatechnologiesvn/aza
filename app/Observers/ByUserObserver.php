<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/16/2018
 * Time: 12:04 AM
 */

namespace App\Observers;


use Illuminate\Support\Facades\Auth;

class ByUserObserver
{
    protected $userId;

    public function __construct()
    {
        $user = Auth::user();
        if ($user) {
            $this->userId = $user->id;
        }
    }
    public function saving($model)
    {
        $model->updated_by = $this->userId;
    }

    public function saved($model)
    {
        $model->created_by = $this->userId;
    }


    public function updating($model)
    {
        $model->updated_by = $this->userId;
    }

    public function updated($model)
    {
        $model->updated_by = $this->userId;
    }


    public function creating($model)
    {
        $model->created_by = $this->userId;
    }

    public function created($model)
    {
        $model->created_by = $this->userId;
    }


    public function removing($model)
    {
        $model->deleted_by = $this->userId;
    }

    public function removed($model)
    {
        $model->deleted_by = $this->userId;
    }

    public function deleting($model)
    {
        $model->deleted_by = $this->userId;
    }

    public function deleted($model)
    {
        $model->deleted_by = $this->userId;
    }
}
