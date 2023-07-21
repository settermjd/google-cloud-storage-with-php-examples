<?php

declare(strict_types=1);

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\UnableToMoveFile;

include __DIR__.'/vendor/autoload.php';

$storageClient = new StorageClient([
    'keyFilePath' => __DIR__ . '/data/google-storage.json',
]);
$bucket = $storageClient->bucket('<<BUCKET NAME>>');
$adapter = new GoogleCloudStorageAdapter($bucket);
$filesystem = new Filesystem($adapter);

$source = '<<A FILE YOU WANT TO RENAME>>';
$destination = '<<NEW FILE NAME>>';
if (! $filesystem->fileExists($source)) {
    echo "Cannot move/rename {$source} as it does not exist.";
    exit();
}

try {
    $filesystem->move($source, $destination);
    echo "File was successfully moved from {$source} to {$destination}.";
} catch (FilesystemException | UnableToMoveFile $e) {
    echo "Could not move/rename the file: {$source}. Reason: {$e->getMessage()}";
}
