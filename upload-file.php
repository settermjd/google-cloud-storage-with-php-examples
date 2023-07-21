<?php

declare(strict_types=1);

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\UnableToWriteFile;

include __DIR__.'/vendor/autoload.php';

$storageClient = new StorageClient([
    'keyFilePath' => __DIR__ . '/data/google-storage.json',
]);
$bucket = $storageClient->bucket('<<BUCKET NAME>>');
$adapter = new GoogleCloudStorageAdapter($bucket);
$filesystem = new Filesystem($adapter);

try {
    $filesystem->writeStream(
        '/',
        fopen(__DIR__ . '/<<A FILE YOU WANT TO UPLOAD>>', 'r')
    );
    echo "File was successfully uploaded/written to Google Cloud Storage.";
} catch (FilesystemException | UnableToWriteFile $e) {
    echo "Could not upload/write the file to Google Storage. Reason: {$e->getMessage()}";
}
