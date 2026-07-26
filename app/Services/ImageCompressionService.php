<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class ImageCompressionService
{
    protected ImageManager $manager;
    protected int $webpQuality;
    protected int $jpegQuality;
    protected int $maxWidth;
    protected int $maxHeight;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
        $this->webpQuality = 80;
        $this->jpegQuality = 85;
        $this->maxWidth = 1920;
        $this->maxHeight = 1920;
    }

    public function compressAndStore(UploadedFile $file, string $path, ?string $filename = null): array
    {
        $image = $this->manager->read($file->getRealPath());

        $image = $this->resizeIfNeeded($image);

        $filename = $filename ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '-', $filename));

        $storedFiles = [];

        $webpPath = $path . '/' . $filename . '.webp';
        $encoded = $image->toWebp($this->webpQuality);
        Storage::disk('public')->put($webpPath, $encoded);
        $storedFiles['webp'] = $webpPath;

        $jpegPath = $path . '/' . $filename . '.jpg';
        $encoded = $image->toJpeg($this->jpegQuality);
        Storage::disk('public')->put($jpegPath, $encoded);
        $storedFiles['jpeg'] = $jpegPath;

        return $storedFiles;
    }

    public function compressExisting(string $sourcePath, string $destPath, ?string $filename = null): array
    {
        $fullPath = Storage::disk('public')->path($sourcePath);
        if (!file_exists($fullPath)) {
            throw new \RuntimeException("Source file not found: $fullPath");
        }

        $image = $this->manager->read($fullPath);
        $image = $this->resizeIfNeeded($image);

        $filename = $filename ?? pathinfo($sourcePath, PATHINFO_FILENAME);
        $filename = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '-', $filename));

        $storedFiles = [];

        $webpPath = $destPath . '/' . $filename . '.webp';
        $encoded = $image->toWebp($this->webpQuality);
        Storage::disk('public')->put($webpPath, $encoded);
        $storedFiles['webp'] = $webpPath;

        $jpegPath = $destPath . '/' . $filename . '.jpg';
        $encoded = $image->toJpeg($this->jpegQuality);
        Storage::disk('public')->put($jpegPath, $encoded);
        $storedFiles['jpeg'] = $jpegPath;

        return $storedFiles;
    }

    public function compressImageData(string $imageData, string $destPath, string $filename): array
    {
        $image = $this->manager->read($imageData);
        $image = $this->resizeIfNeeded($image);

        $filename = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '-', $filename));

        $storedFiles = [];

        $webpPath = $destPath . '/' . $filename . '.webp';
        $encoded = $image->toWebp($this->webpQuality);
        Storage::disk('public')->put($webpPath, $encoded);
        $storedFiles['webp'] = $webpPath;

        $jpegPath = $destPath . '/' . $filename . '.jpg';
        $encoded = $image->toJpeg($this->jpegQuality);
        Storage::disk('public')->put($jpegPath, $encoded);
        $storedFiles['jpeg'] = $jpegPath;

        return $storedFiles;
    }

    protected function resizeIfNeeded($image)
    {
        $width = $image->width();
        $height = $image->height();

        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            $image->scaleDown(width: $this->maxWidth, height: $this->maxHeight);
        }

        return $image;
    }

    public function setQuality(int $webp, int $jpeg): self
    {
        $this->webpQuality = $webp;
        $this->jpegQuality = $jpeg;
        return $this;
    }

    public function setMaxDimensions(int $width, int $height): self
    {
        $this->maxWidth = $width;
        $this->maxHeight = $height;
        return $this;
    }
}
