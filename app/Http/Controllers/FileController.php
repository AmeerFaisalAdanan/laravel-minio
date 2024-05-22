<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client as S3Client;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $minio_access_key = env('MINIO_ACCESS_KEY_ID');
        $minio_secret_key = env('MINIO_SECRET_ACCESS_KEY');
        $minio_bucket = env('MINIO_BUCKET');
        $minio_endpoint = env('MINIO_ENDPOINT');
        // $object_name = 'test.png';

        $file = $request->file('file');


        $client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => $minio_endpoint,
            'use_path_style_endpoint' => false,
            'credentials' => [
                'key' => $minio_access_key,
                'secret' => $minio_secret_key,
            ],
            'http' => [
                'verify' => false
            ],
        ]);


        $client->putObject([
            'Bucket' => $minio_bucket,
            'Key' => $file->getClientOriginalName(),
            'SourceFile' => $file->getPathname(),
        ]);

        $url = $client->getObjectUrl($minio_bucket, $file->getClientOriginalName());

        return response()->json(
            [
                'url' => $url,
            ]
        );

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $minio_access_key = env('MINIO_ACCESS_KEY_ID');
        $minio_secret_key = env('MINIO_SECRET_ACCESS_KEY');
        $minio_bucket = env('MINIO_BUCKET');
        $minio_endpoint = env('MINIO_ENDPOINT');
        $object_name = 'test.png';


        $client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => $minio_endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $minio_access_key,
                'secret' => $minio_secret_key,
            ],
        ]);

        return response()->json(
            [
                'url' => $client->getObjectUrl($minio_bucket, $object_name),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
