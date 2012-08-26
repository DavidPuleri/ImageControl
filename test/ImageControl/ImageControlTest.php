<?php

namespace ImageControl;


class ImageControlTest extends \PHPUnit_Framework_TestCase
{

    function setUp(){
            
    }
    
    
    function testImageControlConstruct()
    {
        $pathToFile = __DIR__ . '/../fixtures/P1030912.JPG';
        $ic = new Load($pathToFile);
        $this->assertEquals($pathToFile, $ic->getImageSource()->getPath());
    }

    function testSaveThumbnailHappyPath()
    {
                
        $pathToFile = __DIR__ . '/../fixtures/P1030912.JPG';
        
        $ic = new Load($pathToFile);        

        $thumbnail1 = new Format\Jpg();
        $thumbnail1->setWidth(1024);
        $thumbnail1->setHeight(768);

        $thumbnail2 = new Format\Jpg();
        $thumbnail2->setWidth(640);
        $thumbnail2->setHeight(480);

        $thumbnail3 = new Format\Jpg();
        $thumbnail3->setWidth(320);

        $thumbnail4 = new Format\Jpg();
        $thumbnail4->setHeight(240);
       
        $destinationPath1 = __DIR__ . '/../fixtures/miniature/mini1.jpg';
        $ic->prepareThumbnail($thumbnail1, $destinationPath1);
        
        $destinationPath2 = __DIR__ . '/../fixtures/miniature/mini2.jpg';
        $ic->prepareThumbnail($thumbnail2, $destinationPath2);
        
        $destinationPath3 = __DIR__ . '/../fixtures/miniature/mini3.jpg';
        $ic->prepareThumbnail($thumbnail3, $destinationPath3);
        
        $destinationPath4 = __DIR__ . '/../fixtures/miniature/mini4.jpg';
        $ic->prepareThumbnail($thumbnail4, $destinationPath4);

       
        $preparedThumbnail = $ic->getPreparedThumbnails();
               
        $this->assertSame($thumbnail1, $preparedThumbnail[$destinationPath1], 'Ensure thumbnail are properly prepared');
        $this->assertSame($thumbnail2, $preparedThumbnail[$destinationPath2], 'Ensure thumbnail are properly prepared');
        $this->assertSame($thumbnail3, $preparedThumbnail[$destinationPath3], 'Ensure thumbnail are properly prepared');
        $this->assertSame($thumbnail4, $preparedThumbnail[$destinationPath4], 'Ensure thumbnail are properly prepared');
        
        $ic->saveThumbnails();
        
        $this->assertTrue(is_file($destinationPath1), "Ensure File is properly generated");
        $this->assertTrue(is_file($destinationPath2), "Ensure File is properly generated");
        $this->assertTrue(is_file($destinationPath3), "Ensure File is properly generated");
        $this->assertTrue(is_file($destinationPath4), "Ensure File is properly generated");
        
        $this->assertGreaterThan(0, filesize($destinationPath1), "Ensure file is not empty");
        $this->assertGreaterThan(0, filesize($destinationPath2), "Ensure file is not empty");
        $this->assertGreaterThan(0, filesize($destinationPath3), "Ensure file is not empty");
        $this->assertGreaterThan(0, filesize($destinationPath4), "Ensure file is not empty");
        
        @unlink($destinationPath1);
        @unlink($destinationPath2);
        @unlink($destinationPath3);
        @unlink($destinationPath4);
    }

}