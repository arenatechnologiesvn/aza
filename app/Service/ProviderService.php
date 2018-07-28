<?php

namespace App\Service;

use App\Provider;
use App\Service\MediaService;

class ProviderService extends BaseService
{
    protected $selectable = [
        'id',
        'code',
        'name',
        'description',
        'address',
        'zone',
        'phone',
        'home_phone',
        'province_code',
        'district_code',
        'ward_code',
        'contract_at'
    ];

    public function __construct(Provider $provider, MediaService $mediaService)
    {
        $this->model = $provider;
        $this->mediaService = $mediaService;
    }

    public function toDto($selectable = null)
    {
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }

    protected function selectable()
    {
        return $this->model->select($this->selectable)
            ->with(['logo' => function($query) {
                $query->select([
                    'id',
                    \DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                ]);
            }]);
    }

    protected function afterSave($provider, $params)
    {
        if ($params['logo']) {
            $this->mediaService->syncMedia($provider, $params['logo'], 'provider');
        }
    }
}