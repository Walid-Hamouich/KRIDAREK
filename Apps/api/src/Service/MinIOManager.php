<?php

namespace App\Service;

use Aws\S3\S3Client;

class MinIOManager
{

    private S3Client $s3client;
    private string $bucketName;

    public function __construct(
        string $endPoint = 'http://minio:9000',
        string $bucketName = 'mybucket',
        string $key = 'minioadmin',
        string $secret = 'minioadmin',
    ) {
        $this->s3client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => $endPoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $key,
                'secret' => $secret
            ]
        ]);
        $this->bucketName = $bucketName;
    }

    public function uploadFile(string $key, string $filePath)
    {
        $this->s3client->putObject([
            'Bucket' => $this->bucketName,
            'Key' => $key,
            'SourceFile' => $filePath,
        ]);
    }

    public function downloadFile(string $key)
    {
        return $this->s3client->getObject([
            'Bucket' => $this->bucketName,
            'Key' => $key
        ]);
    }

    public function deleteFile(string $key)
    {
        $this->s3client->deleteObject([
            'Bucket' => $this->bucketName,
            'Key' => $key
        ]);
    }
}
