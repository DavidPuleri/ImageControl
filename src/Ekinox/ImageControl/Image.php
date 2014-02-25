<?php

namespace Ekinox\ImageControl;

/**
 * This class represent an image. 
 */
abstract class Image
{
    private $height;
    private $width;
    private $path;
    private $mime;
    private $content;
    protected $quality = 75;
    
    public function __construct(){}
    /**
     * Create an new image inside $image by keeping it's properties
     */
    
    abstract protected function createImage(Image $image);
    
    /**
     * Populate the property of the image based from a path
     * 
     * @param string $pathToFile
     * @return \ImageControl\Image 
     */
    public function loadFromPath($pathToFile)
    {
    
        $this->path = $pathToFile;
        $imageSize = @getimagesize($pathToFile);        
        if(false === $imageSize){
            throw new Exception\UnableToGetImageDetailException();
        }
        $this->width = $imageSize[0];
        $this->height = $imageSize[1];
        $this->mime = $imageSize['mime'];
        return $this;
    }
    
    /**
     * Define the quality of the image
     * @param type $quality 
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }
    
    /** 
     * Create an image on certain dimension based on the source
     * @param Image $source
     * @return \ImageControl\Image 
     */
    public function generateImageFromSource(Image $source)
    {
        $this->content = $source->createImage($this);        
        return $this;        
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setWidth($width){
        $this->width = $width;
        return $this;
    }
    
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function getWidth()
    {
        return $this->width;
    }
    
    public function getHeight()
    {
        return $this->height;
    }
    
    public function getMime()
    {
        return $this->mime;
    }
}