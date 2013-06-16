<?php

namespace ImageControl\Format;

use \ImageControl\Image;

class Png extends Image
{

    /**
     * Generate an image from a source based on defined dimensions.
     * @param Image $image
     * @return image stream
     */
    protected function createImage(Image $image)
    {
        ob_start();
        readfile($this->getPath());
        $imageData = ob_get_contents();
        ob_end_clean();
        return $imageData;
    }


}