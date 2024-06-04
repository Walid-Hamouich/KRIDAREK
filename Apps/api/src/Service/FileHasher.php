<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHasher
{

    public function hashFile(UploadedFile $file, string $algo = 'sha512'): string
    {
        $filename = $file->getFilename();
        $extension = $file->getClientOriginalExtension();
        $currentTime = time();
        return hash($algo, "$filename$currentTime") . ".$extension";
    }
}
