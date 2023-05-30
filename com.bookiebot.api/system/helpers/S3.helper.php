<?php

if(!defined("APP")) {
    die("No Direct Access!");
}

use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class S3Helper
{
    private $s3Client;

    public function __construct()
    {
        global $config;

        // Create an S3 client
        $this->s3Client = new \Aws\S3\S3Client([
            'region'  => $config['s3_region'],
            'credentials'=>[
                'key'  => $config['s3_key'],
                'secret'  => $config['s3_secret'],
            ],
            'version' => '2006-03-01'
        ]);
    }


    public function upload($source,$dest) {

        $uploader = new MultipartUploader($this->s3Client, 'test.txt', [
            'bucket' => 'bookiebot.images',
            'key'    => 'test.txt',
        ]);

        try {
            $result = $uploader->upload();
//    print_r($result);
            echo "Upload complete: {$result['ObjectURL']}\n";
        } catch (MultipartUploadException $e) {
            echo $e->getMessage() . "\n";
        }
    }

}