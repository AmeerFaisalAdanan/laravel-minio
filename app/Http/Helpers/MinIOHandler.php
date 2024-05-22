<?php

namespace App\Http\Helpers;

use Aws\S3\S3Client as S3Client;


class MinIOHandler
{

    public static function createClient(){

        $minio_access_key = config('filesystems.disks.s3.key');
        $minio_secret_key = config('filesystems.disks.s3.secret');

        $minio_endpoint = config('filesystems.disks.s3.endpoint');
        $minio_region = config('filesystems.disks.s3.region');
        $minio_use_path_style_endpoint = config('filesystems.disks.s3.use_path_style_endpoint');

        return new S3Client([
            'version' => 'latest',
            'region' => $minio_region,
            'endpoint' => $minio_endpoint,
            'use_path_style_endpoint' => $minio_use_path_style_endpoint,
            'credentials' => [
                'key' => $minio_access_key,
                'secret' => $minio_secret_key,
            ],
            'http' => [
                'verify' => false
            ],
            // 'bucket' => $minio_bucket,
        ]);

    }



}



?>