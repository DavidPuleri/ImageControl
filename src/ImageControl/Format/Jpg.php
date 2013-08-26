<?php

namespace ImageControl\Format;

use \ImageControl\Image;

class Jpg extends Image
{

    /**
     * Generate an image from a source based on defined dimensions.
     * @param Image $image
     * @return type
     */
    protected function createImage(Image $image)
    {
        $source = imagecreatefromjpeg($this->getPath());

        if ($image->getWidth() >= $this->getWidth()) {

            ob_start();
            imagejpeg($source, null, $this->quality);
            $imageData = ob_get_contents();
            ob_end_clean();
            return $imageData;
        }


        if (null === $image->getHeight()) {
            $height = ceil($image->getWidth() * $this->getHeight() / $this->getWidth());
            $image->setHeight($height);
        }

        if (null === $image->getWidth()) {
            $width = ceil($image->getHeight() * $this->getWidth() / $this->getHeight());
            $image->setWidth($width);
        }

        $new_image = imagecreatetruecolor($image->getWidth(), $image->getHeight());
        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $image->getWidth(), $image->getHeight(), $this->getWidth(), $this->getHeight());

        ob_start();
        imagejpeg($new_image, null, $this->quality);
        $imageData = ob_get_contents();
        ob_end_clean();

        return $imageData;
    }


}