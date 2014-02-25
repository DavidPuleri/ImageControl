<?php

namespace Ekinox\ImageControl;

use Ekinox\ImageControl\Exception\FileNotFoundException;
use Ekinox\ImageControl\Exception\ThumbnailAlreadyExistsException;
use Ekinox\ImageControl\Exception\UnableToCreateFolderException;
use Ekinox\ImageControl\Exception\UnableToWriteToFolderException;
use Ekinox\ImageControl\Exception\ExtensionNotSupportedException;
use Ekinox\ImageControl\Format\Jpg;

class Load
{

    private $imageSource;
    private $thumbnails = array();
    private $keepOriginal = true;

    public function __construct($pathToFile)
    {

        if (!is_file($pathToFile)) {
            throw new FileNotFoundException('File Not Found ' . $pathToFile);
        }

        $pathInfo = pathinfo($pathToFile);
        $extension = (string) ucfirst(strtolower($pathInfo['extension']));
        $extension = '\\' . __NAMESPACE__ . '\\Format\\' . $extension;


        try {
            $reflectionClass = new \ReflectionClass($extension);
        } catch (\Exception $e) {
            throw new Exception\ExtensionNotSupportedException($extension);
        }

        $this->imageSource = new $extension();
        $this->imageSource->loadFromPath($pathToFile);
    }

    /**
     * Define if you want to keep the original on save
     * @param type $status
     */
    public function setKeepOriginal($status)
    {
        $this->keepOriginal = $status;
    }

    /**
     * @return Image
     */
    public function getImageSource()
    {
        return $this->imageSource;
    }

    /**
     * Make sure that the destination path is writable, unique.
     * Create folder if required
     * Generate the thumbnail from it source and keep all of that within the object.
     *
     * @param Image $image
     * @param string $destination
     * @return \ImageControl\Load
     *
     * @throws ThumbnailAlreadyExistsException
     * @throws UnableToCreateFolderException
     * @throws UnableToWriteToFolderException
     */
    public function prepareThumbnail(Image $image, $destination)
    {
        if (isset($this->thumbnails[$destination])) {
            throw new ThumbnailAlreadyExistsException();
        }

        $this->preparePath($destination);
        $image->generateImageFromSource($this->imageSource);



        $this->thumbnails[$destination] = $image;
        return $this;
    }

    /**
     * @param Image $image
     * @return mixed
     */
    public function outputThumbnail(Image $image)
    {
        return $image->generateImageFromSource($this->imageSource)->getContent();
    }


    public function getPreparedThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * Save thumbnail to destination path.
     * Delete the source if asked
     *
     * @return boolean
     */
    public function saveThumbnails()
    {
        foreach ($this->thumbnails as $destinationPath => $image) {

            $this->preparePath($destinationPath);
            $fo = fopen($destinationPath, 'w');
            fwrite($fo, $image->getContent());
            fclose($fo);
        }

        if (false === $this->keepOriginal) {
            $isDeleted = @unlink($this->getPathSourceFile());
        }

        return true;
    }

    private function preparePath($path)
    {
        $pathInfo = pathinfo($path);
        $dir = $pathInfo['dirname'];
        if (!is_dir($dir)) {

            $dirCreated = @mkdir($dir, 0755, true);
            if (!$dirCreated) {
                throw new UnableToCreateFolderException('Unable to create folder ' . $dir);
            }

            if (!is_writable($dir)) {
                throw new UnableToWriteToFolderException('Unable to create folder ' . $dir);
            }
        }
    }

    public function output()
    {
        return $this->getImageSource()->getContent();
    }

}