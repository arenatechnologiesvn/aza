<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/20/2018
 * Time: 10:08 PM
 */

namespace App\Service;


use App\Setting;

class SettingService
{
    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function action($action, $key, $data = null){
        $value = null;
        if (isset($data) && isset($data[$key])){
            $value = $data[$key];
        }
        switch ($action) {
            case 'get':
                $popup = $this->model->where('key', '=', $key)->get()->first();
                if (isset($popup))
                    $popup->value = json_decode($popup->value);
                return $popup;
            case 'post':
                $popup = $this->model->where('key', '=', $key)->get()->first();
                if ($popup) {
                    $popup->value = json_encode($value, true);
                } else {
                    $popup = new Setting;
                    $popup->key = $key;
                    $popup->value = json_encode($value, true);
                }
                $popup->save();
                $popup->value = json_decode($popup->value);
                return $popup;
            default:
                return $this->model->where('key', '=', $key)->get()->first();

        }
    }
}