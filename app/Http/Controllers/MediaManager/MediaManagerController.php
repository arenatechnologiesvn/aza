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

class MediaManagerController extends Controller
{
    private static $OBJECT_TYPES = ['profile', 'shop', 'product'];

    /**
     * Get the list of images for Media Manager.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->input('type') || !in_array($request->input('type'), $this::$OBJECT_TYPES)) {
            return response(['message' => 'params is invalid'], 433);
        }

        $uploadUser = Auth::user();
        $images = $uploadUser->getMedia($request->input('type'));
        return response()->json(['data' => $images], 200);
    }

    /**
     * Upload a given image coming from Request object and using Intervention to generate
     * thumb and main image and making the Media entry as well.
     *
     * @param Request $request
     * @param MediaUploader $mediaUploader
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function uploadMediaImage(Request $request, MediaUploader $mediaUploader)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'file|image'
        ]);

        // if there are validation errors, show that
        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 433);
        }

        if (!$request->input('type') || !in_array($request->input('type'), $this::$OBJECT_TYPES)) {
            return response(['message' => 'params is invalid'], 433);
        }

        $file = $request->file('file');
        $folder = 'uploads/' .$request->input('type'). '/' . Carbon::now()->year . '/' . Carbon::now()->month . '/';
        $uniqid = uniqid();
        $mainFileName = $uniqid . '.' . $file->getClientOriginalExtension();
        $thumbFileName = $uniqid . '_thumb.' . $file->getClientOriginalExtension();

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

        // Set mediable object
        $uploadUser = Auth::user();
        $uploadUser->attachMedia($media, $request->input('type'));

        $thumbImage = Image::make($request->file('file'))
            ->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path($folder) . $thumbFileName);

        return response()->json(['data' => 'success'], 200);
    }

    /**
     * delete a media.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMediaImage(Request $request)
    {
        if (!$request->input('imageId') || !$request->input('type') || !in_array($request->input('type'), $this::$OBJECT_TYPES)) {
            return response(['message' => 'params is invalid'], 433);
        }

        $media = Media::find($request->input('imageId'));
        if (!$media) return response('Image not found', 400);

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
}
