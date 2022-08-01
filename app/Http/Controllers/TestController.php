<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Common\Crypto;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


use Aws\S3\S3Client;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{

    public function testEncrypt(Request $request)
    {

        $plaintext = $request->input("plaintext");

        $crypto = new Crypto();

        $ciphertext = $crypto->encrypt($plaintext);
        //store $cipher, $iv, and $tag for decryption later
        $original_plaintext = $crypto->decrypt($ciphertext);
        return response()->json([
            "original" => $original_plaintext,
            "cipher" => $ciphertext,
        ]);
    }


    public function test(Request $request)
    {
        DB::enableQueryLog();
        $currentCourse = Course::where('id', 1)->first();
        $exam = $currentCourse->exam->first();
        return response()->json([$exam->question, DB::getQueryLog()]);
    }

    public function testPresignURL(Request $request)
    {
        $uploadController = new UploadController();

        $uploadController->uploadToS3();
    }


    public function callOutsideAPI1($query, $options)
    {
        $apiCaller = new API1Caller($query, $option);
        return $apiCaller
            ->validate()
            ->request()
            ->modifyData();
    }

    public function callOutsideAPI2()
    {
        $apiCaller = new API2Caller($query, $option);
        return $apiCaller
            ->validate()
            ->request();
    }

    public function index()
    {
    }
    public function create()
    {
    }
    public function store()
    {
    }
    public function update()
    {
    }
    public function destroy()
    {
    }
    public function edit()
    {
    }
    public function show()
    {
    }
}


trait CallableTrait
{
    public function getData()
    {
        return $this->validate()->request()->modifyData();
    }
}

class APICaller
{
    use CallableTrait;

    public function validate()
    {
        return $this;
    }

    public function request()
    {
        return $this;
    }

    public function modifyData()
    {
        $article = new Article;
        $article->fill([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $article->reformatContent([
            'newLine' => 'CRLF',
            'title' => 'uppercase'
        ]);
        $article->save(Article::FAST_SAVE);

        //OR

        $category->article()->create($request->all());
    }
}
