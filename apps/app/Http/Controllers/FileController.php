<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\MinIOHandler;
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
    // public function store(Request $request){

    //     $file = $request->file('file');

    //     $store = Storage::disk('minio')->put($file->getClientOriginalName(), $file);

    //     return $store;


    //     // dd($store);



    //     return response()->json(
    //         [
    //             'url' => Storage::disk('s3')->url($file->getClientOriginalName()),
    //         ]
    //     );





    // }

    
    public function store(Request $request)
    {

        $file = $request->file('file');
        // dd($minio_endpoint);


        MinIOHandler::uploadFile($file->getPathname(), 'images/' . $file->getClientOriginalName());



        // get url of the uploaded file


        $url = Storage::disk('s3')->url('images/' . $file->getClientOriginalName());

        return response()->json(
            [
                'url' => $url,
            ]
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(){


        $content = Storage::disk('s3')->url('output-onlinepngtools.png');

        dd($content);


        return response()->json(
            [
                'content' => $content,
            ]);
    }




    // public function show()
    // {        // $minio_access_key = env('MINIO_ACCESS_KEY_ID');
    //     // $minio_secret_key = env('MINIO_SECRET_ACCESS_KEY');
    //     // $minio_bucket = env('MINIO_BUCKET');
    //     // $minio_endpoint = env('MINIO_ENDPOINT');
    //     $object_name = 'test.png';
    //     $minio_bucket = config('filesystems.disks.s3.bucket');

    //     $client = MinIOHandler::createClient();



    //     return response()->json(
    //         [
    //             'url' => $client->getObjectUrl($minio_bucket, $object_name),
    //         ]
    //     );
    // }

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
