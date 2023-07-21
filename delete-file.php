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

$source = "<<A FILE YOU WANT TO DELETE>>";
if (! $filesystem->fileExists($source)) {
    echo "Cannot delete {$source} as it does not exist.";
    exit();
}

try {
    $filesystem->delete($source);
    echo "File ({$source}) was successfully deleted.";
} catch (FilesystemException | UnableToMoveFile $e) {
    echo "Could not delete the file: {$source}. Reason: {$e->getMessage()}";
}
