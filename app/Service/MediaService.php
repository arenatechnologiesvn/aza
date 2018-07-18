<?php
/*
*   Refer from Plank/Laravel-Mediable
*   Link: https://laravel-mediable.readthedocs.io/en/latest/index.html
*/

namespace App\Service;

use Plank\Mediable\Media;

class MediaService
{
    protected $selectable = [
        'id',
        'disk',
        'directory',
        'filename',
        'extension',
        'mime_type',
        'aggregate_type',
        'size'
    ];

    public function __construct(Media $model)
    {
        $this->model = $model;
    }

    public function getMedia($mediable, $tags)
    {
        return $mediable->getMedia($tags);
    }

    public function attachMedia($mediable, $ids, $tags)
    {
        $mediable->attachMedia($ids, $tags);
    }

    public function syncMedia($mediable, $ids, $tags)
    {
        $mediable->syncMedia($ids, $tags);
    }
}
