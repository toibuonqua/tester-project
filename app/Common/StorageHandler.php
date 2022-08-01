<?php

namespace App\Common;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageHandler
{
    public function __construct($option = [])
    {
        $env = App::environment();

        if ($env !== "production") {
            Log::warning("You are not running in Production, so public storage is being used");
        }

        $defaultOption = [
            'presignTime' => now()->addMinutes(5),
            'folder' => 'public-img',
            'filenameGenerator' => function ($file) {
                return Str::uuid() . '-' . substr($file->getClientOriginalName(), -100);
            }
        ];
        $this->option = array_merge($defaultOption, $option);
    }


    public function getPresignedURL($filePath)
    {
        if (strlen($filePath) < 1) {
            return $filePath;
        }

        $env = App::environment();

        if ($env !== "production") {

            if (Storage::disk('public')->has($filePath)) {
                return asset("storage/$filePath");
            }
            return "";
        }

        $url = Storage::temporaryUrl(
            $filePath,
            $this->option['presignTime']
        );

        return $url;
    }

    public function uploadToPresignedURL(Request $request)
    {
        throw new Exception("This function has not been implemented yet");
    }

    /**
     * Upload file into S3 with default configuration
     *
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $file extracted from $request->file('filename-tag')
     * @param Array $option contain a set of key/value.
     * Default: ```
     * [
     *    'folder' => 'public-img',
     *    'tag' => '',
     *    'filename' => Str::uuid() . '-' . $file->getClientOriginalName()
     * ]
     * ```
     * @return void
     */
    public function upload($file, $customOption = [])
    {

        if ($file === null) {
            return null;
        }

        $defaultOption = [
            'folder' => $this->option['folder'],
            'tag' => '',
            'filename' => $this->option['filenameGenerator']($file),
            // Only get last 100 characters of origin filename to avoid overflow in DB.
        ];

        $option = array_merge($defaultOption, $customOption);
        $env = App::environment();

        if ($env !== "production") {
            // dd($option);
            $result = Storage::disk('public')->put($option['folder'],  $file);

            return $result;
        }


        $result = Storage::putFileAs($option['folder'], $file, $option['filename'], [
            'Tagging' => "env=$env&" . $option['tag'],
            'ACL' => 'public-read'
            // For now, set all uploaded files as public
            // TODO: Need to disable public access and only use preSigned URL in the future.
        ]);

        return $result;
    }


    public function delete($url, $customOption = [])
    {
        return Storage::delete($url);
    }
}
