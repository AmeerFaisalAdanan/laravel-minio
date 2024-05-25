<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
// use App\Http\Helpers\MinIOHandler;
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

        $minio_access_key = config('filesystems.disks.s3.key');
        $minio_secret_key = config('filesystems.disks.s3.secret');
        $minio_bucket = config('filesystems.disks.s3.bucket');
        $minio_endpoint = config('filesystems.disks.s3.endpoint');
        $use_path_style_endpoint = config('filesystems.disks.s3.use_path_style_endpoint');
        // $object_name = 'test.png';

        $file = $request->file('file');
        // dd($minio_endpoint);


        $client = new S3Client([
            'version' => 'latest',
            'region' => 'my-central-1',
            'endpoint' => $minio_endpoint,
            'use_path_style_endpoint' => true,
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
    {        // $minio_access_key = env('MINIO_ACCESS_KEY_ID');
        // $minio_secret_key = env('MINIO_SECRET_ACCESS_KEY');
        // $minio_bucket = env('MINIO_BUCKET');
        // $minio_endpoint = env('MINIO_ENDPOINT');

        $minio_access_key = config('filesystems.disks.s3.key');
        $minio_secret_key = config('filesystems.disks.s3.secret');

        $minio_endpoint = config('filesystems.disks.s3.endpoint');
        $minio_region = config('filesystems.disks.s3.region');
        $minio_use_path_style_endpoint = config('filesystems.disks.s3.use_path_style_endpoint');
        $object_name = 'tewst.png';
        $minio_bucket = config('filesystems.disks.s3.bucket');

        // $client = MinIOHandler::createClient();

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

        dd($client->getObjectUrl($minio_bucket, $object_name));



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
