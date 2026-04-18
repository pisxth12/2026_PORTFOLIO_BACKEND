<?php

namespace App\Helpers;

class ImageHelper
{
    public static function getUrl($path)
    {
        if (!$path) return null;

        // Already full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $cloudName = config('cloudinary.cloud.cloud_name', 'dztestiof');


        if (str_ends_with($path, '.pdf')) {
            return "https://res.cloudinary.com/{$cloudName}/raw/upload/{$path}";
        }

        // For images
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
    }
}
