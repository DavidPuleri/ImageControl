<?php

namespace ImageControl;

class JpgTest extends \PHPUnit_Framework_TestCase
{

    function testLoadImageFromPath()
    {
        $pathToFile = __DIR__ . '/../fixtures/P1030912.JPG';

        
        $i = new Format\Jpg();
        $i->loadFromPath($pathToFile);
        
        $this->assertInstanceOf('ImageControl\Image', $i);
        $this->assertEquals(3648, $i->getWidth());
        $this->assertEquals(2736, $i->getHeight());
        $this->assertEquals('image/jpeg', $i->getMime());
    }

    function testCreateEmptyImage()
    {
        $i = new Format\Jpg();
        $this->assertSame($i, $i->setHeight(1000), 'Ensure fluid interface');
        $this->assertSame($i, $i->setWidth(1000), 'Ensure fluid interface');
        
        $this->assertEquals(1000, $i->getHeight());
        $this->assertEquals(1000, $i->getWidth());
    }

}
