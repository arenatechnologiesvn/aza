<?php

namespace App\Http\Controllers\MediaManager;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;
use App\Http\Controllers\Controller;
use App\Service\MediaService;
use App\Http\Requests\Media\StoreMediaIndex;
use App\Http\Requests\Media\StoreMediaCreate;
use App\Http\Requests\Media\StoreMediaDelete;

class MediaManagerController extends Controller
{
    public function __construct(MediaService $service)
    {
        $this->service = $service;
    }

    /**
     * Get the list of images for Media Manager.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(StoreMediaIndex $request)
    {
        $medias = Media::where('directory', 'like', '%'.$request->input('type').'%')->get();
        return $this->api_success_response(['data' => $medias]);
    }

    /**
     * Upload a given image coming from Request object and using Intervention to generate
     * thumb and main image and making the Media entry as well.
     *
     * @param Request $request
     * @param MediaUploader $mediaUploader
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function uploadMediaImage(StoreMediaCreate $request, MediaUploader $mediaUploader)
    {
        $file = $request->file('file');
        $folder = 'uploads/' .$request->input('type'). '/' . Carbon::now()->year . '/' . Carbon::now()->month . '/';
        $uniqid = uniqid();
        $mainFileName = $uniqid . '.' . $file->getClientOriginalExtension();
        // $thumbFileName = $uniqid . '_thumb.' . $file->getClientOriginalExtension();

        // checking if the folder exist
        // if not, create the folder
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }

        $mainImage = Image::make($request->file('file'))
            ->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path($folder) . $mainFileName);

        // making the media entry
        $media = $mediaUploader->fromSource(public_path($folder) . $mainFileName)
            ->toDirectory($folder)
            ->upload();

        // $thumbImage = Image::make($request->file('file'))
        //     ->resize(400, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     })
        //     ->save(public_path($folder) . $thumbFileName);

//        if (\App::environment('staging')) {
            $stagingFolder = base_path() . '/uploads/' .$request->input('type'). '/' . Carbon::now()->year . '/' . Carbon::now()->month . '/';
            if (!file_exists($stagingFolder)) {
                mkdir($stagingFolder, 0755, true);
            }
    
            $mainImage = Image::make($request->file('file'))
                ->resize(1080, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($stagingFolder . $mainFileName);
//        }

        return $this->api_success_response();
    }

    /**
     * delete a media.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMediaImage(StoreMediaDelete $request)
    {
        $media = Media::find($request->input('imageId'));

        // delete media file from directory
        $directory = $media->disk . '/' . $media->directory;
        $files = Storage::files($directory);
        if (count($files) > 1) {
            $mediaPath = $directory . '/' . $media->filename . '.' . $media->extension;
            Storage::delete($mediaPath);
        } else {
            Storage::deleteDirectory($directory);
        }

        // delete media from Media table
        $media->delete();

        return response()->json(['data' => [$files, $media->directory]], 200);
    }

    public function imageMetaData(Request $request)
    {
        $media = Media::find($request->input('currentImageId'));

        if (!$media) {
            return response('Image not found', 400);
        }

        $metaData = [
            'alt' => ($request->has('alt')) ? $request->input('alt') : '',
            'caption' => ($request->has('caption')) ? $request->input('caption') : '',
        ];
        $media->meta_data = json_encode($metaData);
        $media->save();

        return $media;
    }

    private function getMediaTags($type)
    {
        return $type == 'product' ? ['preview', 'featured'] : $type;
    }
}
