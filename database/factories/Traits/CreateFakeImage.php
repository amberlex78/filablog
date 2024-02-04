<?php

namespace Database\Factories\Traits;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait CreateFakeImage
{
    public function createImage(?string $url = null): ?string
    {
        try {
            $image = file_get_contents(DatabaseSeeder::IMAGE_URL);
        } catch (Throwable) {
            return null;
        }

        $filename = Str::uuid() . '.jpg';
        $filename = $url ? ($url . '/' . $filename) : $filename;

        Storage::disk('public')->put($filename, $image);

        return $filename;
    }
}
