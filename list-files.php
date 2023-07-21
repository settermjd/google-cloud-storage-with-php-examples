<?php

declare(strict_types=1);

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\FileAttributes;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\StorageAttributes;

include __DIR__.'/vendor/autoload.php';

$storageClient = new StorageClient([
    'keyFilePath' => __DIR__ . '/data/google-storage.json',
]);
$bucket = $storageClient->bucket('<<BUCKET NAME>>');
$adapter = new GoogleCloudStorageAdapter($bucket);
$filesystem = new Filesystem($adapter);

$files = $filesystem
    ->listContents('/')
    ->filter(fn (StorageAttributes $attributes) => $attributes->isFile())
    ->sortByPath()
    ->toArray();

echo "Files available in {$bucket->name()}:\n";

/** @var FileAttributes $file */
foreach ($files as $file) {
    printf("- %s,%s,%s\n", $file->fileSize(), $file->mimeType(), $file->path());
}
