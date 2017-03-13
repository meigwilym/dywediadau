<?php

namespace App\Classes;

/**
 * Description of Files
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class Resources
{
    /**
     * Get a random font from the resources fontsndir
     *
     * @return string
     */
    public function getFontRandom()
    {
        return $this->getRandomFile(resource_path('fonts'));
    }

    /**
     * Get a random image from the resources img dir
     * @return type
     */
    public function getImgRandom()
    {
        return $this->getRandomFile(resource_path('img'));
    }

    private function getRandomFile($path)
    {
        $files = scandir($path);
        $imgs = array_diff($files, array('.', '..'));

        $rand = $imgs[array_rand($imgs)];

        return $path.DIRECTORY_SEPARATOR.$rand;
    }
}